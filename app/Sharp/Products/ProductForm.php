<?php

namespace App\Sharp\Products;
use App\Models\Product;
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

class ProductForm extends SharpForm
{
    use WithSharpFormEloquentUpdater;

    public function buildFormFields(FieldsContainer $formFields): void
    {
        $formFields
            ->addField(
                SharpFormTextField::make('reference')
                    ->setLabel('Reference')
            )
            ->addField(

                SharpFormListField::make('product_special')
                    ->setLabel('Reference')
            )
            ->addField(
                SharpFormTextField::make('name')
                    ->setLabel('Name')
            )
            ->addField(
                SharpFormEditorField::make('description')
                    ->setLabel('Web description')
                    ->setToolbar([SharpFormEditorField::B, SharpFormEditorField::I, SharpFormEditorField::CODE_BLOCK, SharpFormEditorField::RAW_HTML])
            )
            ->addField(
                SharpFormNumberField::make('price')
                    ->setLabel('Price')
            )
            ->addField(
                SharpFormCheckField::make(
                    "is_requester",
                    "The requester is the legal representant"
                )
            )->addField(
                SharpFormTextField::make("last_name")
                    ->addConditionalDisplay("!is_requester")
            );
//dd($formFields->getFields()[2]);
            //asta va supra scrie campul de mai sus
            // $formFields->addField(
            //     SharpFormEditorField::make('description')
            //         ->setLabel('Web description')
            //         ->setToolbar([SharpFormEditorField::UL])
            // );

            // $formFields->getFields()[2] = SharpFormEditorField::make('description')
            //          ->setLabel('Web description')
            //          ->setToolbar([SharpFormEditorField::UL]);
    }

    public function buildFormLayout(FormLayout $formLayout): void
    {
        $formLayout
            ->addTab('Content', function (FormLayoutTab $tab) {
                $tab
                    ->addColumn(6, function (FormLayoutColumn $column) {
                        $column->withSingleField('reference');
                        $column->withSingleField('is_requester');
                        $column->withSingleField('last_name');
                    })
                    ->addColumn(6, function (FormLayoutColumn $column) {
                        $column->withSingleField('name');
                        $column->withSingleField('description');
                    });
            })
            ->addTab('Price', function (FormLayoutTab $tab) {
                $tab
                    ->addColumn(12, function (FormLayoutColumn $column) {
                        $column->withFieldset('Price', function (FormLayoutFieldset $fieldset) {
                            $fieldset->withSingleField('price');
                        });
                    });
            });
    }

    public function find(mixed $id): array
    {
        return $this->transform(Product::findOrFail($id));
    }

    public function update(mixed $id, array $data)
    {
        $product = $id
        ? Product::findOrFail($id)
        : new Product();

        $data = collect($data)->except(['is_requester', 'last_name']);

        $this->save($product, $data->toArray());

        return $product->id;
    }

    public function delete(mixed $id): void
    {
        throw new SharpApplicativeException('Not allowed');
    }
}
