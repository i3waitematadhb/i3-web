<?php

namespace {

    use CWP\CWP\PageTypes\NewsPage;
    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Assets\Image;
    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
    use SilverStripe\Forms\ListboxField;
    use SilverStripe\ORM\DataExtension;
    use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
    use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

    class NewsHolderExtension extends DataExtension
    {
        private static $has_many = [
            'NewsPageCategories' => NewsPageCategory::class
        ];

        public function updateCMSFields(FieldList $fields)
        {
            $gridConfig = GridFieldConfig_RecordEditor::create(999);
            if($this->owner->NewsPageCategories()->Count())
            {
                $gridConfig->addComponent(new GridFieldOrderableRows());
            }
            $gridConfig->addComponent(new GridFieldEditableColumns());
            $gridColumns = $gridConfig->getComponentByType(GridFieldEditableColumns::class);
            $gridColumns->setDisplayFields([
                'Archived' => [
                    'title' => 'Archive',
                    'callback' => function($record, $column, $grid) {
                        return CheckboxField::create($column);
                    }]
            ]);

            $gridField = GridField::create(
                'Categories',
                'Categories',
                $this->owner->NewsPageCategories(),
                $gridConfig
            );

            $fields->removeByName("NewsPageCategories");
            $fields->addFieldToTab('Root.Categories', $gridField);
        }
    }
}
