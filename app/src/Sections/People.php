<?php

namespace {

    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\ListboxField;
    use TractorCow\SliderField\SliderField;

    class People extends Section
    {
        private static $singular_name = 'People List';

        private static $db = [
            'NumPerRow' => 'Int',
        ];

        private static $many_many  = [
            'Staff' => StaffPage::class
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', SliderField::create('NumPerRow', 'Projects per row', 2, 4)
                ->setDescription('Limit items per row'));
            $fields->addFieldToTab('Root.Main', ListboxField::create('Staff', 'People',
                StaffPage::get()->map("ID", "Title")));
        }
    }
}
