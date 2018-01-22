# Query Filters Package for Laravel

Heavily inspired by and adapted from: 
https://github.com/laracasts/Dedicated-Query-String-Filtering 

## Install

To install via Composer, run the following command:

    composer require macgriog/laravel-query-filters

## Usage

Create a custom filter class for a model, and add filter methods for each query parameter. By convention, every method named filter + <QueryParam> will be applied to Eloquent's Query Builder. 

Example: 

    use Macgriog\QueryFilters\QueryFilter;

    CustomerFilter extends QueryFilter
    {   
        // will be called for request query param "name"
        public function filterName($value = '')
        {
            return $this->builder
                ->where('name', 'like', "%{$value}%");
        }
    
        // will be called for request query param "email"
        public function filterEmail($value = '')
        {
            ///...
        }
    }

Then in your model class add the trait:

    use Macgriog\QueryFilters\Traits\Filterable;
    use Illuminate\Database\Eloquent\Model;
    

    class Customer extends Model
    {
        use Filterable;

        ...
    }

And in your controller:

    use Acme\CustomerFilter;

    ...
        public function index(CustomerFilter $query)
        {
            return Customer::filter($query);
        }
