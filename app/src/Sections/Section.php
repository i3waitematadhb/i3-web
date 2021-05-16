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
    use SilverStripe\Forms\ListboxField;
    use SilverStripe\Forms\Tab;
    use SilverStripe\Forms\TabSet;
    use SilverStripe\Forms\TextField;
    use SilverStripe\ORM\ArrayList;
    use SilverStripe\ORM\DataObject;
    use SilverStripe\View\ArrayData;
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
            'SectionType'      => 'Varchar',
            'SectionHeader'    => 'HTMLText',
            'SectionContainer' => 'Text',
            'SectionHeaderSize'=> 'Varchar',
            'SectionHeaderPosition' => 'Varchar',
            'ShowSectionHeader'     => 'Boolean',
            'SectionFooter'     => 'HTMLText',
            'SectionFooterSize' => 'Varchar',
            'ShowSectionFooter' => 'Boolean',
            'SectionBgType' => 'Varchar',
            'SectionBgColor'=> Color::class,
            'SectionPadding'=> 'Varchar',
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

            /**
             * Section Settings
             */
            $fields->addFieldToTab('Root.Settings', DropdownField::create('SectionWidth', 'Section width',
                SectionWidth::get()->filter('Archived', false)->map('Class', 'Name')));
            $fields->addFieldToTab('Root.Settings', DropdownField::create('SectionContainer', 'Section container',
                array(
                    'container p-0'       => 'Fix-width',
                    'container-fluid p-0' => 'Container fluid',
                    'container-small p-0' => 'Container small'
                )
            )->setDescription('<b>Fix-width</b> container (its max-width changes at each breakpoint)</br><b>Container fluid</b> for a full width container, spanning the entire width of the viewport.</br><b>Container small</b> (max-width fixed at 575px)'));
            $fields->addFieldToTab('Root.Settings', ListboxField::create('SectionPadding', 'Section Paddings',
                Padding::get()->map('Class', 'Name')));
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
                $bgImage->setFolderName('Sections/Background/Images');
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
                Padding::get()->map('Class', 'Name')));
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
                Padding::get()->map('Class', 'Name')));
                $sectionFooterSize->displayIf('ShowSectionFooter')->isChecked();

            $instance = self::singleton($this->SectionType);
            $instance->ID = $this->ID;
            $instance->getSectionCMSFields($fields);

            $fields->addFieldToTab('Root.CodeEditor', CodeEditorField::create('CodeEditor'));
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

        public function getReadablePaddings()
        {
            $output = new ArrayList();
            $paddings = json_decode($this->SectionPadding);
            if ($paddings) {
                foreach ($paddings as $padding) {
                    $output->push(
                        new ArrayData(array('Name' => $padding))
                    );
                }
            }
            return $output;
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
    }
}
