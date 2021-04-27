<?php

namespace {

    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Assets\Image;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
    use SilverStripe\ORM\ArrayList;
    use SilverStripe\TagField\StringTagField;
    use SilverStripe\View\ArrayData;

    class ResourcesOrPublication extends Section
    {
        private static $singular_name = 'Resources or Publication';

        private static $db = [
            'Content' => 'HTMLText',
            'Abstract'=> 'HTMLText',
            'Filters' => 'Text',
            'Authors' => 'Text',
        ];

        private static $has_one = [
            'Image' => Image::class
        ];

        private static $owns = [
            'Image'
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', UploadField::create('Image', 'Featured image')
                ->setFolderName('Sections/Section_ResourcesOrPublication/Images'));
            $fields->addFieldToTab('Root.Main', HTMLEditorField::create('Content'));
            $fields->addFieldToTab('Root.Main', StringTagField::create('Filters', 'Categories',
                FilterItem::get()->filter('Archived', false), explode(',', $this->Filters))->setCanCreate(true));
            $fields->addFieldToTab('Root.Main', StringTagField::create('Authors', 'Author/s',
                StaffPage::get(), explode(',', $this->Authors))->setCanCreate(true));
            $fields->addFieldToTab('Root.Main', HTMLEditorField::create('Abstract'));
        }

        public function getReadableFilters()
        {
            $filterLists = $this->Filters;
            $filters = explode(',', $filterLists);

            $output = new ArrayList();
            foreach ($filters as $filter) {
                $output->push(
                    new ArrayData(array('Name' => $filter))
                );
            }

            return $output;
        }

        public function getReadableAuthors()
        {
            $authorLists = $this->Authors;
            $authors = explode(',', $authorLists);

            $output = new ArrayList();
            foreach ($authors as $author) {
                $output->push(
                    new ArrayData(array('Name' => $author))
                );
            }
            return $output;
        }
    }
}
