<?php

namespace {

    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Assets\Image;
    use SilverStripe\CMS\Model\SiteTree;
    use SilverStripe\Core\ClassInfo;
    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\GroupedDropdownField;
    use SilverStripe\Forms\HiddenField;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
    use SilverStripe\Forms\Tab;
    use SilverStripe\Forms\TabSet;
    use SilverStripe\Forms\TextField;
    use SilverStripe\ORM\DataObject;
    use SwiftDevLabs\CodeEditorField\Forms\CodeEditorField;
    use TractorCow\Colorpicker\Color;
    use TractorCow\Colorpicker\Forms\ColorField;

    class Section extends DataObject
    {
        private static $default_sort = 'Sort';
        private static $singular_name = 'Content Section';

        private static $db = [
            'Name'    => 'Text',
            'Content' => 'HTMLText',
            'ContentAnimation' => 'Varchar',
            'ContentWidth'     => 'Varchar',
            'SectionType'      => 'Varchar',
            'SectionHeader'    => 'HTMLText',
            'SectionHeaderSize'=> 'Varchar',
            'SectionHeaderPosition' => 'Varchar',
            'ShowSectionHeader'     => 'Boolean',
            'SectionFooter'     => 'HTMLText',
            'SectionFooterSize' => 'Varchar',
            'ShowSectionFooter' => 'Boolean',
            'SectionBgType' => 'Varchar',
            'SectionBgColor'=> Color::class,
            'SectionPadding'=> 'Varchar',
            'SectionPaddingNice' => 'Varchar',
            'SectionOffsetSidePadding' => 'Boolean',
            'SectionWidth'  => 'Varchar',
            'ColorGradient1'=> Color::class,
            'ColorGradient2'=> Color::class,
            'CodeEditor'    => 'HTMLText',
            'Archived'      => 'Boolean',
            'Sort'          => 'Int'
        ];

        private static $has_one = [
            'Page'              => Page::class,
            'SectionFooterPage' => SiteTree::class,
            'SectionBgImage'    => Image::class
        ];

        private static $owns = [
            'SectionBgImage'
        ];

        private static $summary_fields = [
            'Name',
            'SectionWidth',
            'SectionType',
            'SectionHeaderReadable' => 'Show section header',
            'Status'
        ];

        private function getSectionTypes()
        {
            $sectionTypes = array();
            $classes = ClassInfo::getValidSubClasses('Section');
            foreach ($classes as $type) {
                $instance = self::singleton($type);
                $sectionTypes[$instance->ClassName] = $instance->singular_name();
            }
            return $sectionTypes;
        }

        public function getCMSFields()
        {
            $fields = new FieldList();
            $fields->push(TabSet::create("Root", $mainTab = Tab::create("Main")));

            if ($this->SectionType) {
                $fields->addFieldToTab('Root.Main',
                    $rot =  TextField::create('ROSectionType', 'Section type',
                        self::singleton($this->SectionType)->singular_name()));
                $rot->setDisabled(true);
            } else {
                $fields->addFieldToTab('Root.Main', DropdownField::create("SectionType", "Section type",
                    $this->getSectionTypes() , $this->ClassName));
            }

            $fields->addFieldToTab('Root.Main', TextField::create('Name', ' Section name'));

            if ($this->SectionType == 'Section') {
                $fields->addFieldToTab('Root.Main', HTMLEditorField::create('Content'));
                $fields->addFieldToTab('Root.Main', DropdownField::create('ContentWidth', 'Select content width',
                    array(
                        'container-fluid p-0' => 'Full width',
                        'container p-0'       => 'Fix width'
                    )
                ));
                $fields->addFieldToTab('Root.Main', DropdownField::create('ContentAnimation', 'Select content animation',
                    Animation::get()->filter('Archived', false)->map('Name', 'Name')));
            }

            /**
             * Section Settings
             */
            $fields->addFieldToTab('Root.Settings', DropdownField::create('SectionWidth', 'Section width',
                array(
                    'col-lg-2' => '16%',
                    'col-lg-3' => '25%',
                    'col-lg-4' => '33%',
                    'col-lg-5' => '41%',
                    'col-lg-6' => '50%',
                    'col-lg-7' => '58%',
                    'col-lg-8' => '66%',
                    'col-lg-9' => '75%',
                    'col-lg-10' => '83%',
                    'col-lg-11' => '91%',
                    'col-lg-12' => '100%',
                )
            ));
            $fields->addFieldToTab('Root.Settings', GroupedDropdownField::create('SectionPadding', 'Section padding', $this->paddingSettings()));
            $fields->addFieldToTab('Root.Settings', $offset = CheckboxField::create('SectionOffsetSidePadding', 'Offset padding on both sides'));
                $offset->displayIf('SectionPadding')->isNotEqualTo('none');

            $fields->addFieldToTab('Root.Settings', DropdownField::create('SectionBgType', 'Section background type',
                array(
                    'none'             => 'None',
                    'background-image' => 'Background image',
                    'background-color' => 'Background color',
                    'background-gradient' => 'Background gradient'
                )
            ));
            $fields->addFieldToTab('Root.Settings', $bgColor = ColorField::create('SectionBgColor', 'Section background color'));
                $bgColor->displayIf('SectionBgType')->isEqualTo('background-color');
            $fields->addFieldToTab('Root.Settings', $bgImage = UploadField::create('SectionBgImage', 'Section background image'));
                $bgImage->displayIf('SectionBgType')->isEqualTo('background-image');
                $bgImage->setFolderName('Section/Background_Images');
            $fields->addFieldToTab('Root.Settings', ColorField::create('ColorGradient1', 'Gradient color 1')
                ->displayIf('SectionBgType')->isEqualTo('background-gradient')->end());
            $fields->addFieldToTab('Root.Settings', ColorField::create('ColorGradient2', 'Gradient color 2')
                ->displayIf('SectionBgType')->isEqualTo('background-gradient')->end());
            $fields->addFieldToTab('Root.Settings', CodeEditorField::create('CodeEditor'));

            /**
             * Section Header
             */
            $fields->addFieldToTab('Root.Header', CheckboxField::create('ShowSectionHeader'));
            $fields->addFieldToTab('Root.Header', $sectionHeader = HTMLEditorField::create('SectionHeader', 'Section header content'));
                $sectionHeader->displayIf('ShowSectionHeader')->isChecked();
            $fields->addFieldToTab('Root.Header', $sectionHeaderSize = GroupedDropdownField::create('SectionHeaderSize', 'Section header padding size',
                $this->paddingSettings()));
                $sectionHeaderSize->displayIf('ShowSectionHeader')->isChecked();
            $fields->addFieldToTab('Root.Header', $sectionHeaderPos = DropdownField::create('SectionHeaderPosition', 'Section header position',
                array(
                    'position-left'  => 'Left',
                    'position-top'   => 'Top',
                    'position-right' => 'Right'
                )
            ));
                $sectionHeaderPos->displayIf('ShowSectionHeader')->isChecked();

            /**
             *  Section Footer
             */
            $fields->addFieldToTab('Root.Footer', CheckboxField::create('ShowSectionFooter'));
            $fields->addFieldToTab('Root.Footer', HTMLEditorField::create('SectionFooter', 'Section footer content')
                ->displayIf('ShowSectionFooter')->isChecked()->end());
            $fields->addFieldToTab('Root.Footer', $sectionFooterSize = GroupedDropdownField::create('SectionFooterSize', 'Section footer padding size',
                $this->paddingSettings()));
                $sectionFooterSize->displayIf('ShowSectionFooter')->isChecked();

            $instance = self::singleton($this->SectionType);
            $instance->ID = $this->ID;
            $instance->getSectionCMSFields($fields);

            $fields->addFieldToTab('Root.Settings', CodeEditorField::create('CodeEditor'));
            $fields->addFieldToTab('Root.Main', CheckboxField::create('Archived'));
            $fields->addFieldToTab('Root.Main', HiddenField::create('Sort'));

            return $fields;
        }

        public function getSectionCMSFields(FieldList $fields)
        {
            return $fields;
        }

        public function onBeforeWrite()
        {
            parent::onBeforeWrite();
            $this->ClassName = $this->SectionType;
            if($this->Name == ''){
                $this->Name = $this->SectionType;
            }

//            if ($this->SectionOffsetSidePadding == '1') {
//                $this->SectionPaddingNice = 'pt-md-'.$this->SectionPadding.' pb-md-'.$this->SectionPadding;
//            } else {
//                $this->SectionPaddingNice = 'p-md-'.$this->SectionPadding;
//            }

            //$generatedID = substr(str_shuffle(str_repeat($chars='0123456789', ceil(5/strlen($chars)) )),1, 15);
        }

        public function getDisplaySectionType()
        {
            return self::singleton($this->SectionType)->singular_name();
        }

        public function getDisplayTypeTrim()
        {
            return str_replace(' ','', self::singleton($this->SectionType)->singular_name());
        }

        public function Show()
        {
            return $this->renderWith('Layout/Sections/' . $this->ClassName);
        }

        public function getSectionHeaderReadable()
        {
            if ($this->ShowSectionHeader == 1) return _t('GridField.Yes', 'Yes');
            return _t('GridField.No', 'No');
        }

        public function getStatus()
        {
            if($this->Archived == 1) return _t('GridField.Archived', 'Archived');
            return _t('GridField.Live', 'Live');
        }

        public function paddingSettings()
        {
            return array(
                "All sides Padding" => array(
                    'none'   => 'None',
                    'p-md-1' => 'XLight',
                    'p-md-2' => 'Light',
                    'p-md-3' => 'XSmall',
                    'p-md-4' => 'Small',
                    'p-md-5' => 'Regular',
                    'p-md-6' => 'Medium',
                    'p-md-7' => 'Large',
                    'p-md-8' => 'XLarge',
                    'p-md-9' => 'XXLarge',
                    'p-md-10' => 'XXXLarge'
                ),
                "Top and Bottom Paddings" => array(
                    'pt-md-1 pb-md-1' => 'XLight',
                    'pt-md-2 pb-md-2' => 'Light',
                    'pt-md-3 pb-md-3' => 'XSmall',
                    'pt-md-4 pb-md-4' => 'Small',
                    'pt-md-5 pb-md-5' => 'Regular',
                    'pt-md-6 pb-md-6' => 'Medium',
                    'pt-md-7 pb-md-7' => 'Large',
                    'pt-md-8 pb-md-8' => 'XLarge',
                    'pt-md-9 pb-md-9' => 'XXLarge',
                    'pt-md-10 pb-md-10' => 'XXXLarge',
                ),
                "Left and Right Paddings" => array(
                    'pl-md-1 pr-md-1' => 'XLight',
                    'pl-md-2 pr-md-2' => 'Light',
                    'pl-md-3 pr-md-3' => 'XSmall',
                    'pl-md-4 pr-md-4' => 'Small',
                    'pl-md-5 pr-md-5' => 'Regular',
                    'pl-md-6 pr-md-6' => 'Medium',
                    'pl-md-7 pr-md-7' => 'Large',
                    'pl-md-8 pr-md-8' => 'XLarge',
                    'pl-md-9 pr-md-9' => 'XXLarge',
                    'pl-md-10 pr-md-10' => 'XXXLarge',
                ),
                "Top Padding" => array(
                    'pt-md-1' => 'XLight',
                    'pt-md-2' => 'Light',
                    'pt-md-3' => 'XSmall',
                    'pt-md-4' => 'Small',
                    'pt-md-5' => 'Regular',
                    'pt-md-6' => 'Medium',
                    'pt-md-7' => 'Large',
                    'pt-md-8' => 'XLarge',
                    'pt-md-9' => 'XXLarge',
                    'pt-md-10' => 'XXXLarge',
                ),
                "Bottom Padding" => array(
                    'pb-md-1' => 'XLight',
                    'pb-md-2' => 'Light',
                    'pb-md-3' => 'XSmall',
                    'pb-md-4' => 'Small',
                    'pb-md-5' => 'Regular',
                    'pb-md-6' => 'Medium',
                    'pb-md-7' => 'Large',
                    'pb-md-8' => 'XLarge',
                    'pb-md-9' => 'XXLarge',
                    'pb-md-10' => 'XXXLarge',
                ),
                "Right Padding" => array(
                    'pr-md-1' => 'XLight',
                    'pr-md-2' => 'Light',
                    'pr-md-3' => 'XSmall',
                    'pr-md-4' => 'Small',
                    'pr-md-5' => 'Regular',
                    'pr-md-6' => 'Medium',
                    'pr-md-7' => 'Large',
                    'pr-md-8' => 'XLarge',
                    'pr-md-9' => 'XXLarge',
                    'pr-md-10' => 'XXXLarge',
                ),
                "Left Padding" => array(
                    'pl-md-1' => 'XLight',
                    'pl-md-2' => 'Light',
                    'pl-md-3' => 'XSmall',
                    'pl-md-4' => 'Small',
                    'pl-md-5' => 'Regular',
                    'pl-md-6' => 'Medium',
                    'pl-md-7' => 'Large',
                    'pl-md-8' => 'XLarge',
                    'pl-md-9' => 'XXLarge',
                    'pl-md-10' => 'XXXLarge',
                ),
            );
        }
    }
}
