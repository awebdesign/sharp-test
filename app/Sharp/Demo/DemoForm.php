<?php

namespace App\Sharp\Demo;
use App\Models\Demo;
use Code16\Sharp\Form\Eloquent\WithSharpFormEloquentUpdater;
use Code16\Sharp\Form\Layout\FormLayout;
use Code16\Sharp\Form\Layout\FormLayoutColumn;
use Code16\Sharp\Form\SharpForm;
use Code16\Sharp\Utils\Fields\FieldsContainer;
use Code16\Sharp\Form\Fields\SharpFormEditorField;
use Code16\Sharp\Form\Fields\SharpFormTextField;
use Code16\Sharp\Form\Fields\SharpFormNumberField;
use Code16\Sharp\Exceptions\Form\SharpApplicativeException;
use Code16\Sharp\Form\Layout\FormLayoutFieldset;
use Code16\Sharp\Form\Layout\FormLayoutTab;
use Code16\Sharp\Form\Fields\SharpFormCheckField;
use Code16\Sharp\Form\Fields\SharpFormListField;

class DemoForm extends SharpForm
{
    use WithSharpFormEloquentUpdater;

    public function buildFormFields(FieldsContainer $formFields): void
    {
        $formFields
            ->addField(
                SharpFormTextField::make('name')
                    ->setLabel('Name')
            );
    }

    public function buildFormLayout(FormLayout $formLayout): void
    {
        $formLayout
            ->addTab('Content', function (FormLayoutTab $tab) {
                $tab
                    ->addColumn(12, function (FormLayoutColumn $column) {
                        $column->withSingleField('name');
                    });
            });
    }

    public function find(mixed $id): array
    {
        return $this->transform(Demo::findOrFail($id));
    }

    public function update(mixed $id, array $data)
    {
        $demo = $id
        ? Demo::findOrFail($id)
        : new Demo();

        $this->save($demo, $data);

        return $demo->id;
    }

    public function delete(mixed $id): void
    {
        throw new SharpApplicativeException('Not allowed');
    }
}
