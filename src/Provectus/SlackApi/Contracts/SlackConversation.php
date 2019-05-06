<?php

namespace Provectus\SlackApi\Contracts;

/**
 * Interface SlackConversation
 *
 * @package Provectus\SlackApi\Contracts
 */
interface SlackConversation
{
    /**
     * @param $exclude_archived
     * @param int $limit default=100
     * @param array $types   of available types : [public_channel,private_channel]
     *
     * @return mixed
     */
    public function lists($exclude_archived, $types, $limit = 100);
}