
# Laravel Model Validator

A Laravel package to add validation rules and messages at the model level.

## Installation

Install the package via composer:

```bash
composer require sandaffo/laravel-model-validator
```

## Usage

### Adding Validation to a Model

To add validation to a model, define the `rules` and `messages` properties in your model:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sandaffo\LaravelModelValidator\ModelExtensions;

class Post extends Model
{
    use ModelExtensions;

    protected static \$rules = [
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:posts',
        'description' => 'required|string|min:8',
    ];

    protected static \$messages = [
        'title.required' => 'The title field is required.',
        'slug.required' => 'The slug field is required.',
        'description.required' => 'The description field is required.',
    ];
}
```

### Example

Below is an example demonstrating the usage of the package:

```php
\$p = new Post();
\$p->title = "Test Post One";
\$p->slug = "test-post-one";
\$p->description = "Test post one description";

if (\$p->isValid()) {
    echo "Post is valid
";
    \$p->save();
} else {
    echo "Post is not valid
";
    print_r(\$p->errors());
}
```

### Tinker Example

```bash
\$ php artisan tinker
```

```php
\$p = new Post();
\$p->title = "Test Post One";
\$p->slug = "test-post-one";
\$p->description = "Test post one description";

\$p->isValid(); // true
\$p->errors(); // []

\$p->errorMessages(); // []

\$p->getRules();
// [
//     "title" => "required|string|max:255",
//     "slug" => "required|string|max:255|unique:posts",
//     "description" => "required|string|min:8",
// ]

\$p->getMessages(); // []

\$p->getValidator();
// Illuminate\Validation\Validator { ... }

\$p->getValidator()->errors();
// Illuminate\Support\MessageBag { ... }

\$p->save(); // true

\$p;
// App\Models\Post {
//     title: "Test Post One",
//     slug: "test-post-one",
//     description: "Test post one description",
//     updated_at: "2024-07-24 08:45:45",
//     created_at: "2024-07-24 08:45:45",
//     id: 1,
// }
```

## Methods

- `isValid()`: Checks if the model is valid according to the defined rules.
- `errors()`: Returns an array of validation errors.
- `errorMessages()`: Returns an array of error messages.
- `getRules()`: Returns the validation rules.
- `getMessages()`: Returns the validation messages.
- `getValidator()`: Returns the validator instance.

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
