<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Core\Timeline;

class Timeline
{
    /**
     * Registered pinable subjects
     */
    protected static array $pinableSubjects = [];

    /**
     * Register pinable subject
     *
     * @param  array  $subject List of the models that are pinable
     */
    public static function acceptsPinsFrom(array $subject): void
    {
        // If exists, merge the accepts only
        if (static::getPinableSubject($subject['as'])) {
            $index = array_search($subject['as'], array_column(static::$pinableSubjects, 'as'));

            static::$pinableSubjects[$index]['accepts'] = array_merge(
                static::$pinableSubjects[$index]['accepts'],
                $subject['accepts']
            );

            return;
        }

        static::$pinableSubjects[] = $subject;
    }

    /**
     * Flush the pinable subjects cache
     */
    public static function flushPinableSubjects(): void
    {
        static::$pinableSubjects = [];
    }

    /**
     * Get pinable subject
     */
    public static function getPinableSubject(string $subject): ?array
    {
        return collect(static::$pinableSubjects)->firstWhere('as', $subject);
    }

    /**
     * Get subject accepted timelineable
     */
    public static function getSubjectAcceptedTimelineable(string $subject, string $timelineableType): ?array
    {
        $accepts = static::getPinableSubject($subject)['accepts'] ?? [];

        return collect($accepts)->firstWhere('as', $timelineableType);
    }
}
