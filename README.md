# Uploadable

A trait to automatically handle file uploads for Laravel models.

## Example Usage

    use MikeFrancis\Uploadable\Uploadable;
    use Illuminate\Database\Eloquent\Model;

    class Post extends Model {

      use Uploadable;

      protected $uploadable = ['featured_image'];

    }

Let's break it down. First we include the trait we're going to take advantage:

    use MikeFrancis\Uploadable\UploadableTrait;

Then in our model we use the trait:

    use UploadableTrait;

Our model's `$uploadbale` is an array of file input name attributes which you'd like to be automatically handled by the trait.

It's as simple as that. Standby for more features coming soon!