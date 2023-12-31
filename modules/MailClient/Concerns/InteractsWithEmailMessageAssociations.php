<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Concerns;

use Modules\Core\Resource\Resource;
use Modules\MailClient\Client\Compose\AbstractComposer;
use Modules\MailClient\Client\Contracts\MessageInterface;
use Modules\MailClient\Models\EmailAccountMessage;

trait InteractsWithEmailMessageAssociations
{
    /**
     * Associations separator
     */
    protected string $associationsSeparator = ';';

    /**
     * When sending a message, we need to add the associations uuids as headers to the message
     */
    protected function addComposerAssociationsHeaders(AbstractComposer $composer, array $associations): void
    {
        foreach (EmailAccountMessage::resource()->availableAssociations() as $resource) {
            if (isset($associations[$resource->name()])
                    && is_array($associations[$resource->name()])) {
                $associations = $associations[$resource->name()];
                if ($relatedModels = $this->getRelatedResourceModels($resource, $associations)) {
                    $composer->addHeader(
                        $this->createAssociationHeaderName($resource->name()),
                        implode($this->associationsSeparator, $relatedModels->pluck('uuid')->all())
                    );
                }
            }
        }
    }

    /**
     * Sync the message associations via the header
     */
    protected function syncAssociationsViaMessageHeaders(EmailAccountMessage $dbMessage, MessageInterface $remoteMessage): void
    {
        foreach (EmailAccountMessage::resource()->availableAssociations() as $resource) {
            if ($header = $remoteMessage->getHeader($this->createAssociationHeaderName($resource->name()))) {
                if (empty($header->getValue())) {
                    continue;
                }

                $dbMessage->{$resource->associateableName()}()->syncWithoutDetaching(
                    $this->getAssociatedModelsViaHeaderUuids($resource, $header->getValue())
                );
            }
        }
    }

    /**
     * Get the associate models via the uuids
     *
     * @param  string  $uuids The header value uuids
     * @return \Illuminate\Support\Collection
     */
    protected function getAssociatedModelsViaHeaderUuids(Resource $resource, string $uuids)
    {
        $uuids = explode($this->associationsSeparator, $uuids);

        return $resource->newModel()->whereIn('uuid', $uuids);
    }

    /**
     * Create associations header name for a given resource
     */
    protected function createAssociationHeaderName(string $resourceName): string
    {
        return 'X-Concord-'.ucfirst($resourceName).'-Assoc';
    }

    /**
     * Get the related resource models
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getRelatedResourceModels(Resource $resource, array $associations)
    {
        if (count($associations) === 0) {
            return false;
        }

        return $resource->newModel()->findMany($associations);
    }
}
