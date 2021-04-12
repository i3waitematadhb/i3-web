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
            'DisplaySectionType' => 'Section Type',
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
                $fields->addFieldToTab('Root.Main', DropdownField::create('ContentAnimation', 'Select content animation',
                    Animation::get()->filter('Archived', false)->map('Name', 'Name')));
            }

            $fields->addFieldToTab('Root.Main', DropdownField::create('ContentWidth', 'Select content width',
                array(
                    'container-fluid p-0' => 'Full width',
                    'container p-0'       => 'Fix width'
                )
            ));

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

            if ($this->SectionOffsetSidePadding == '1') {
                $this->SectionPaddingNice = 'pt-lg-'.$this->SectionPadding.' pb-lg-'.$this->SectionPadding;
            } else {
                $this->SectionPaddingNice = 'p-lg-'.$this->SectionPadding;
            }

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
                    'p-lg-1' => 'XLight',
                    'p-lg-2' => 'Light',
                    'p-lg-3' => 'XSmall',
                    'p-lg-4' => 'Small',
                    'p-lg-5' => 'Regular',
                    'p-lg-6' => 'Medium',
                    'p-lg-7' => 'Large',
                    'p-lg-8' => 'XLarge',
                    'p-lg-9' => 'XXLarge',
                    'p-lg-10' => 'XXXLarge'
                ),
                "Top and Bottom Paddings" => array(
                    'pt-lg-1 pb-lg-1' => 'XLight',
                    'pt-lg-2 pb-lg-2' => 'Light',
                    'pt-lg-3 pb-lg-3' => 'XSmall',
                    'pt-lg-4 pb-lg-4' => 'Small',
                    'pt-lg-5 pb-lg-5' => 'Regular',
                    'pt-lg-6 pb-lg-6' => 'Medium',
                    'pt-lg-7 pb-lg-7' => 'Large',
                    'pt-lg-8 pb-lg-8' => 'XLarge',
                    'pt-lg-9 pb-lg-9' => 'XXLarge',
                    'pt-lg-10 pb-lg-10' => 'XXXLarge',
                ),
                "Left and Right Paddings" => array(
                    'pl-lg-1 pr-lg-1' => 'XLight',
                    'pl-lg-2 pr-lg-2' => 'Light',
                    'pl-lg-3 pr-lg-3' => 'XSmall',
                    'pl-lg-4 pr-lg-4' => 'Small',
                    'pl-lg-5 pr-lg-5' => 'Regular',
                    'pl-lg-6 pr-lg-6' => 'Medium',
                    'pl-lg-7 pr-lg-7' => 'Large',
                    'pl-lg-8 pr-lg-8' => 'XLarge',
                    'pl-lg-9 pr-lg-9' => 'XXLarge',
                    'pl-lg-10 pr-lg-10' => 'XXXLarge',
                ),
                "Top Padding" => array(
                    'pt-lg-1' => 'XLight',
                    'pt-lg-2' => 'Light',
                    'pt-lg-3' => 'XSmall',
                    'pt-lg-4' => 'Small',
                    'pt-lg-5' => 'Regular',
                    'pt-lg-6' => 'Medium',
                    'pt-lg-7' => 'Large',
                    'pt-lg-8' => 'XLarge',
                    'pt-lg-9' => 'XXLarge',
                    'pt-lg-10' => 'XXXLarge',
                ),
                "Bottom Padding" => array(
                    'pb-lg-1' => 'XLight',
                    'pb-lg-2' => 'Light',
                    'pb-lg-3' => 'XSmall',
                    'pb-lg-4' => 'Small',
                    'pb-lg-5' => 'Regular',
                    'pb-lg-6' => 'Medium',
                    'pb-lg-7' => 'Large',
                    'pb-lg-8' => 'XLarge',
                    'pb-lg-9' => 'XXLarge',
                    'pb-lg-10' => 'XXXLarge',
                ),
                "Right Padding" => array(
                    'pr-lg-1' => 'XLight',
                    'pr-lg-2' => 'Light',
                    'pr-lg-3' => 'XSmall',
                    'pr-lg-4' => 'Small',
                    'pr-lg-5' => 'Regular',
                    'pr-lg-6' => 'Medium',
                    'pr-lg-7' => 'Large',
                    'pr-lg-8' => 'XLarge',
                    'pr-lg-9' => 'XXLarge',
                    'pr-lg-10' => 'XXXLarge',
                ),
                "Left Padding" => array(
                    'pl-lg-1' => 'XLight',
                    'pl-lg-2' => 'Light',
                    'pl-lg-3' => 'XSmall',
                    'pl-lg-4' => 'Small',
                    'pl-lg-5' => 'Regular',
                    'pl-lg-6' => 'Medium',
                    'pl-lg-7' => 'Large',
                    'pl-lg-8' => 'XLarge',
                    'pl-lg-9' => 'XXLarge',
                    'pl-lg-10' => 'XXXLarge',
                ),
            );
        }
    }
}
