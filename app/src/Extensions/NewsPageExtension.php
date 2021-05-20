<?php

namespace {

    use CWP\CWP\PageTypes\NewsPage;
    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Assets\Image;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\ListboxField;
    use SilverStripe\ORM\ArrayList;
    use SilverStripe\ORM\DataExtension;
    use SilverStripe\TagField\StringTagField;
    use SilverStripe\View\ArrayData;

    class NewsPageExtension extends DataExtension
    {
        private static $db = [
            'NewsPageType'   => 'Varchar',
            'Categories'     => 'Text',
            'PeopleInvolved' => 'Text',
        ];

        private static $has_one = [
            'Image' => Image::class,
        ];

        private static $many_many = [
            'Authors'     => StaffPage::class,
            'RelatedNews' => NewsPage::class,
        ];

        private static $owns = [
            'Image',
        ];

        public function updateCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', DropdownField::create('NewsPageType' , 'Page type',
                array(
                    'news'  => 'News',
                    'blogs' => 'Blogs'
                )
            ), 'Abstract');
            $fields->addFieldToTab('Root.Main', StringTagField::create('Categories', 'Categories',
                $this->owner->getVisibleNewsPageCategories()->map('Title', 'Title'), explode(',', $this->owner->Categories))->setCanCreate(true),'Abstract');
            $fields->addFieldToTab('Root.Main', StringTagField::create('PeopleInvolved', 'People involved',
                StaffPage::get(), explode(',', $this->owner->PeopleInvolved))->setCanCreate(true),'Abstract');
            $fields->addFieldToTab('Root.Main', ListboxField::create('Authors', 'Author/s',
                StaffPage::get()->map("ID", "Title")), 'Abstract');
            $fields->addFieldToTab('Root.Main', ListboxField::create('RelatedNews', 'Related news',
                NewsPage::get()->filter(['Title:not' => $this->owner->Title, 'NewsPageType' => $this->owner->NewsPageType])->map("ID", 'Title')), 'Abstract');
            $fields->addFieldToTab('Root.Main', UploadField::create('Image', 'Featured image')
                ->setFolderName('NewsPage/'.$this->owner->URLSegment.'/Image'),'Abstract');

            $fields->removeFieldFromTab('Root.Main', 'FeaturedImage');
            $fields->removeFieldFromTab('Root.Main', 'Author');
        }

        public function getVisibleNewsPageCategories()
        {
            $output = new ArrayList();
            $categories = $this->owner->getParent()->NewsPageCategories()->filter('Archived', false);
            foreach ($categories as $category) {
                $output->push(
                    new ArrayData(array('Title' => $category->Title))
                );
            }
            return $output;
        }

        public function getReadableAuthors()
        {
            $authorLists = $this->owner->PeopleInvolved;
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
