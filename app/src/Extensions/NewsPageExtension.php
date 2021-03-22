<?php

namespace {

    use CWP\CWP\PageTypes\NewsPage;
    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Assets\Image;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\ListboxField;
    use SilverStripe\ORM\DataExtension;

    class NewsPageExtension extends DataExtension
    {
        private static $db = [
            'NewsPageType' => 'Varchar'
        ];

        private static $has_one = [
            'Image'       => Image::class,
            'BannerImage' => Image::class
        ];

        private static $many_many = [
            'Authors'        => StaffPage::class,
            'PeopleInvolved' => StaffPage::class,
            'RelatedNews'    => NewsPage::class,
        ];

        private static $owns = [
            'Image',
            'BannerImage'
        ];

        public function updateCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', DropdownField::create('NewsPageType' , 'Page type',
                array(
                    'news'  => 'News',
                    'blogs' => 'Blogs'
                )
            ), 'Abstract');
            $fields->addFieldToTab('Root.Main', ListboxField::create('Authors', 'Author/s',
                StaffPage::get()->map("ID", "Title")), 'Abstract');
            $fields->addFieldToTab('Root.Main', ListboxField::create('PeopleInvolved', 'People involved',
                StaffPage::get()->map("ID", "Title")), 'Abstract');
            $fields->addFieldToTab('Root.Main', ListboxField::create('RelatedNews', 'Related news',
                NewsPage::get()->filter(['Title:not' => $this->owner->Title, 'NewsPageType' => $this->owner->NewsPageType])->map("ID", 'Title')), 'Abstract');
            $fields->addFieldToTab('Root.Main', UploadField::create('Image', 'Featured image')
                ->setFolderName('NewsPage/'.$this->owner->URLSegment.'/Image'),'Abstract');
            $fields->addFieldToTab('Root.Main', UploadField::create('BannerImage')
                ->setFolderName('NewsPage/'.$this->owner->URLSegment.'/BannerImage'),'Abstract');

            $fields->removeFieldFromTab('Root.Main', 'FeaturedImage');
            $fields->removeFieldFromTab('Root.Main', 'Author');
        }
    }
}
