<?php

class MY_Session extends CI_Session
{
    function _unserialize($data)
    {
        $retVal = parent::_unserialize($data);
        if (!$retVal) {
            $retVal = unserialize($data);
        }
        return $retVal;
    }

    /**
     * Fetch a specific item from the session array
     *
     * @access    public
     * @param    string
     * @return    mixed
     */
    function userdata($item)
    {
        return (!isset($this->userdata[$item])) ? FALSE : $this->userdata[$item];
    }

}
