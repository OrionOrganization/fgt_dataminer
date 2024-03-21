<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlogPostRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class BlogPostCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlogPostCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation {
        destroy as traitDestroy;
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BlogPost::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blog-post');
        CRUD::setEntityNameStrings('blog post', 'blog posts');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id');

        CRUD::column('title')->label('Título');

        CRUD::addColumn([
            'name' => 'created_at',
            'label' => 'Criado Em',
            'type' => 'datetime'
        ]);

        CRUD::addColumn([
            'name' => 'updated_at',
            'label' => 'Atualizado Em',
            'type' => 'datetime'
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(BlogPostRequest::class);

        CRUD::field('title')->label('Título');

        CRUD::addField([
            'label' => 'Imagem de Capa',
            'name' => 'image',
            'type' => 'image',
            'crop' => false,
            'aspect_ratio' => 1,
        ]);
        
        CRUD::addField(
            [
                'name'  => 'content',
                'label' => 'Conteúdo',
                'type'  => 'summernote',
                'options' => [
                    'toolbar' => [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']],
                        ['insert', ['picture', 'link']]
                    ],
                    'height' => 250
                ],
            ],
        );

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        CRUD::column('title')->label('Título');

        CRUD::addColumn([
            'name' => 'created_at',
            'label' => 'Criação',
            'type' => 'datetime'
        ]);

        CRUD::addColumn([
            'name' => 'updated_at',
            'label' => 'Atualização',
            'type' => 'datetime'
        ]);

        CRUD::addColumn([
            'name' => 'image',
            'label' => 'Imagem Capa',
            'type' => 'image',
            'height' => '300px',
            'width'  => '300px',
        ],);
    }

    protected function store()
    {
        $request = $this->crud->getRequest();

        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->image));

        $imageUrl = $this->storeImageAndGetUrl($image);

        $this->crud->getRequest()->request->add(['image' => $imageUrl]);

        return $this->traitStore();
    }

    protected function update()
    {
        $request = $this->crud->getRequest();
        $entry = $this->crud->getCurrentEntry();

        if ($request->has('image') && Str::startsWith($request->image, 'data:image')) {
            if ($entry->image) {
                $formatedUrlImage = str_replace('storage', 'public', $entry->image);
                Storage::delete($formatedUrlImage);
            }

            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->image));

            $imageUrl = $this->storeImageAndGetUrl($image);

            $this->crud->getRequest()->request->add(['image' => $imageUrl]);
        }

        return $this->traitUpdate();
    }

    public function destroy($id)
    {
        $entry = $this->crud->getCurrentEntry();

        if ($entry->image) {
            $formatedUrlImage = str_replace('storage', 'public', $entry->image);
            Storage::delete($formatedUrlImage);
        }

        return $this->traitDestroy($id);
    }

    /**
     * @param string $image // base64
     * 
     * @return string
     */
    protected function storeImageAndGetUrl(string $image): string
    {
        $imageName = (string) Str::uuid() . ".png";

        Storage::put('public/img/blog-covers/' . $imageName, $image);

        return Storage::url('public/img/blog-covers/' . $imageName);
    }
}
