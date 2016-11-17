<?php

class UserForm extends Form
{
    public function build()
    {
        $this->addFormField('FirstName');
        $this->addFormField('LastName');
        $this->addFormField('Address');
        $this->addFormField('City');
        $this->addFormField('ZipCode');
        $this->addFormField('Phone');
        $this->addFormField('Email');
    }
}