<?php

namespace Trisk\SlackApi\Methods;

use Trisk\SlackApi\Contracts\SlackConversation;

/**
 * Class Conversations
 *
 * @package Trisk\SlackApi\Methods
 */
class Conversation extends SlackMethod implements SlackConversation
{
    protected $methodsGroup = 'conversations.';

    /**
     * This method returns a list of all channels in the team with private and public
     *
     * @see https://api.slack.com/methods/conversations.list
     *
     * @param int $exclude_archived Don't return archived channels.
     * @param string   $types
     * @param int $limit
     *
     * @return array
     */
    public function lists($exclude_archived = 1, $types = 'public_channel,private_channel', $limit = 100)
    {
        return $this->method('list', compact(['exclude_archived', 'types', 'limit']));
    }
}