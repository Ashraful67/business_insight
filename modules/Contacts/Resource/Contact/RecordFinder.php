<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Contacts\Resource\Contact;

use Illuminate\Support\Str;
use Modules\Core\Resource\RecordFinder as BaseRecordFinder;

class RecordFinder extends BaseRecordFinder
{
    public function matchByPhone($phones)
    {
        $this->createCollection();

        if (empty($phones)) {
            return null;
        }

        $numbers = array_filter((array) data_get($phones, '*.number'));

        foreach ($this->records as $contact) {
            if ($contact->phones->contains(function ($phone) use ($numbers) {
                return in_array($phone->number, $numbers);
            })) {
                return $contact;
            }
        }

        return null;
    }

    public function matchByFullName($fullName)
    {
        $this->createCollection();

        if (empty($fullName)) {
            return null;
        }

        foreach ($this->records as $contact) {
            if (Str::lower(trim("$contact->first_name $contact->last_name")) == Str::lower($fullName)) {
                return $contact;
            }
        }

        return null;
    }
}
