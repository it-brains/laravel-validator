# Useful Laravel Validation Rules

## Custom rules

* uniqueModel 
* existsModel

## Examples

### uniqueModel instead just unique 

Instead of 
```
...
use Illuminate\Validation\Rule;
...

public function rules()
{
    return [
        'title' => [
            Rule::unique('containers', 'name')
                ->where('user_id', $this->user()->id)
                ->whereNull('deleted_at'),
        ],
        
        // other rules
        'type' => Rule::in(['A', 'B']),
        ...
    ];
}

...
```

or with table from model's class

```
...
use App\Container;
use Illuminate\Validation\Rule;
...

public function rules()
{
    return [
        'title' => [
            Rule::unique((new Container::class)->getTable(), 'name')
                ->where('user_id', $this->user()->id)
                ->whereNull('deleted_at'),
        ],
        
        // other rules
        'type' => Rule::in(['A', 'B']),
        ...
    ];
}

...
```

Use next

```
...
use App\Container;
use ITBrains\Validation\Rule;
...

public function rules()
{
    return [
        'title' => [
            Rule::uniqueModel(Container::class, 'name')
                ->where('user_id', $this->user()->id),
                
            // other rules
            'type' => Rule::in(['A', 'B']),
            ...
        ],
    ];
}

...
```