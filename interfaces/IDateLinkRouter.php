<?php

/**
 *
 * @author Damo
 */
interface IDateLinkRouter
{
    public function setDateField($field);

    public function getDateField();

    public function RegisterClass($className);
    
    public function RefreshCache();
}