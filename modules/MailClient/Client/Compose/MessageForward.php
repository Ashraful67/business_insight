<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\MailClient\Client\Compose;

use Modules\MailClient\Client\Client;
use Modules\MailClient\Client\FolderIdentifier;

class MessageForward extends AbstractComposer
{
    /**
     * Holds the message ID the forward is intended for
     */
    protected string|int $id;

    /**
     * Holds the folder name the message belongs to
     */
    protected FolderIdentifier $folder;

    /**
     * Create new MessageForward instance.
     */
    public function __construct(Client $client, string|int $remoteId, FolderIdentifier $folder, ?FolderIdentifier $sentFolder = null)
    {
        parent::__construct($client, $sentFolder);

        $this->id = $remoteId;
        $this->folder = $folder;
    }

    /**
     * Forward the message
     *
     * @return \Modules\MailClient\Client\Contracts\MessageInterface
     */
    public function send()
    {
        return $this->client->forward($this->id, $this->folder);
    }
}
