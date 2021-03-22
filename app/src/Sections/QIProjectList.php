<?php

namespace {

    use SilverStripe\Control\Controller;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\TextField;
    use SilverStripe\ORM\ArrayList;
    use SilverStripe\ORM\PaginatedList;
    use SilverStripe\View\ArrayData;

    class QIProjectList extends Section
    {
        private static $singular_name = 'QI Project List';

        private static $description = "For Quality Improvement Page only";

        private static $db = [
            'Limit' => 'Int'
        ];

        private static $has_one = [
           'QIProjectHolder' => QIProjectHolderPage::class
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', TextField::create('Limit', 'Limit number of projects to show'));
            $fields->addFieldToTab('Root.Main', DropdownField::create('QIProjectHolderID', 'Select QI project holder',
                QIProjectHolderPage::get()->map('ID', 'Title')));
        }

        public function getYearFilter() {
            $yearLists =  $this->owner->QIProjectHolder()->FilterYear;
            $years    = explode(",",$yearLists);

            $output = new ArrayList();
            foreach($years as $item) {
                $output->push(
                    new ArrayData(array('title' => $item))
                );
            }
            return $output;
        }

        public function getVisibleQIProjectCategories()
        {
            return QIProjectCategory::get()->filter('Archived', false)->sort('Sort');
        }

        public function QIProjectPages()
        {
            $request = Controller::curr();
            $properties = $this->QIProjectHolder()->Children();
            $paginatedProperties = PaginatedList::create(
                $properties,
                $request->getRequest()
            )->setPageLength(2);

            return $paginatedProperties;
        }
    }
}
