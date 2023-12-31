<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Resource;

use Illuminate\Support\Arr;
use KubAT\PhpSimple\HtmlDomParser;
use Modules\Core\Facades\Innoclapps;
use Modules\Core\Fields\Field;
use Modules\Core\Fields\FieldsCollection;
use Modules\Core\Placeholders\Collection as BasePlaceholders;
use Modules\Core\Placeholders\GenericPlaceholder;
use Modules\Core\Placeholders\Placeholder;
use Modules\Core\Placeholders\UrlPlaceholder;

class Placeholders extends BasePlaceholders
{
    /**
     * Can be nullable because of reflection access.
     *
     * @var \Modules\Core\Resource\Resource
     */
    protected Resource $resource;

    /**
     * Placeholder selector.
     *
     * @var string
     */
    const INPUT_PLACEHOLDER_SELECTOR = '._placeholder';

    /**
     * Initialze new Placeholders instance
     *
     * @param  \Modules\Core\Models\Model|null  $model Provide the model when parsing is needed
     */
    public function __construct(Resource|string $resource, protected $model = null)
    {
        $this->resource = is_string($resource) ?
            Innoclapps::resourceByName($resource) :
            $resource;

        parent::__construct([]);

        $this->setPlaceholdersFromResourceFields();
    }

    /**
     * Create placeholders groups for edit as fields from the given resources
     *
     * @return \Illuminate\Support\Collection
     */
    public static function createGroupsFromResources(array $resources)
    {
        return collect($resources)->mapWithKeys(function ($resourceName) {
            return with(new static($resourceName), fn ($placeholders) => [$resourceName => [
                'label' => $placeholders->getResource()->singularLabel(),
                'placeholders' => $placeholders,
            ]]);
        })->reject(fn ($group) => empty($group['placeholders']));
    }

    /**
     * Clean up the given content from placeholders via input fields.
     */
    public static function cleanup(?string $content): ?string
    {
        if ($content === '' || is_null($content)) {
            return $content;
        }

        $dom = HtmlDomParser::str_get_html($content);

        foreach ($dom->find(static::INPUT_PLACEHOLDER_SELECTOR) as $input) {
            $input->outertext = ! empty($input) ? trim($input->value) : '';
        }

        return $dom->save();
    }

    /**
     * Parse the resource placeholders.
     */
    public function parseWhenViaInputFields(?string $content): ?string
    {
        if ($content === '' || is_null($content)) {
            return $content;
        }

        $placeholders = Arr::dot($this->parse());

        $dom = HtmlDomParser::str_get_html($content);
        $domPlaceholders = $dom->find(static::INPUT_PLACEHOLDER_SELECTOR);

        foreach ($domPlaceholders as $input) {
            foreach ($placeholders as $tag => $value) {
                $htmlTag = $input->getAttribute('data-tag');

                if (empty(trim($input->value)) &&
                    $htmlTag == $tag ||
                    // For previous versions (1.1.9 and below), where the tags were not prefixed with the resource name
                    ($input->hasAttribute('data-group') &&
                            $input->getAttribute('data-group') == $this->resource->name() &&
                            $htmlTag === str_replace($this->resource->singularName().'.', '', $tag)
                    )
                ) {
                    $input->value = $value;

                    if (! empty($value)) {
                        $input->setAttribute('data-autofilled', true);
                    }
                }
            }
        }

        // In case interpolation tags are used directly in the content
        return $this->parseViaInterpolation($dom->save());
    }

    /**
     * Parse all the placeholders with their formatted values.
     */
    public function parseViaInterpolation(?string $content): ?string
    {
        if ($content === '' || is_null($content)) {
            return $content;
        }

        return $this->render($content, $this->parse());
    }

    /**
     * Push an URL placeholder to the placeholders array.
     */
    public function withUrlPlaceholder(string $tag = 'url'): static
    {
        return $this->push(
            UrlPlaceholder::make($this->model, $tag)
                ->prefixTag($this->tagPrefix())
                ->description($this->resource->singularLabel().' URL')
        );
    }

    /**
     * Get the resource class the placeholders are intended for
     */
    public function getResource(): Resource
    {
        return $this->resource;
    }

    /**
     * Get the fields for the placeholders.
     */
    public function fields(): FieldsCollection
    {
        return $this->resource->resolveFields();
    }

    /**
     * Set the resource placeholders.
     */
    protected function setPlaceholdersFromResourceFields(): void
    {
        $this->push($this->fields()->map(function (Field $field) {
            $placeholder = $field->mailableTemplatePlaceholder($this->model);

            if ($placeholder instanceof Placeholder) {
                return $placeholder;
            } elseif (is_string($placeholder)) { // Allow pass value directly without providing placeholder
                return GenericPlaceholder::make($field->attribute)
                    ->description($field->label)
                    ->value($placeholder);
            }
        })
            ->filter()
            ->each->prefixTag($this->tagPrefix())
            ->all());
    }

    /**
     * Get the placeholders tag prefix.
     */
    protected function tagPrefix(): string
    {
        return $this->resource->singularName().'.';
    }
}
