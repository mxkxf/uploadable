# Uploadable

Automatically handle file uploads for Laravel models.

## Usage

    use MikeFrancis\Uploadable\Uploadable;
    use Illuminate\Database\Eloquent\Model;

    class Post extends Model {

      use Uploadable;

      protected $uploadable = [
        'featured_image' => [
          'width'  => 400,
          'height' => 400
        ]
      ];

    }

First we include the trait we're going to take advantage:

    use MikeFrancis\Uploadable\Uploadable;

Then in our model we use the trait:

    use Uploadable;

The package will then use the configuration in `$uploadable` to deal with your file uploads. The keys of this array are the file inputs which you'd like to access.