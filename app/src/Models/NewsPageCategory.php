<?php

namespace {

    use CWP\CWP\PageTypes\NewsHolder;
    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\HiddenField;
    use SilverStripe\Forms\ReadonlyField;
    use SilverStripe\Forms\TextField;
    use SilverStripe\ORM\DataObject;

    class NewsPageCategory extends DataObject
    {
        private static $default_sort = 'Sort ASC';

        private static $db = [
            'Title'    => 'Varchar',
            'Archived' => 'Boolean',
            'Sort'     => 'Int'
        ];

        private static $has_one = [
            'Parent' => NewsHolder::class
        ];

        private static $summary_fields = [
            'Title',
            'Status',
        ];

        public function getCMSFields()
        {
            $fields = parent::getCMSFields(); // TODO: Change the autogenerated stub
            $fields->removeByName('ParentID');
            $fields->addFieldToTab('Root.Main', ReadonlyField::create('ParentRO', 'Parent', $this->Parent()->Title));
            $fields->addFieldToTab('Root.Main', TextField::create('Title', 'Category Name'));
            $fields->addFieldToTab('Root.Main', CheckboxField::create('Archived'));
            $fields->addFieldToTab('Root.Main', HiddenField::create('Sort'));

            return $fields;
        }

        public function getStatus()
        {
            if($this->Archived == 1) return _t('GridField.Archived', 'Archived');
            return _t('GridField.Live', 'Live');
        }
    }
}
