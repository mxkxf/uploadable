# Uploadable

A trait to automatically handle file uploads for Laravel models.

## Example Usage

Here's the package integrated into a bog-standard Laravel 5 model.

    use MikeFrancis\Uploadable\Uploadable;
    use Illuminate\Database\Eloquent\Model;

    class Post extends Model {

      use Uploadable;

      protected $uploadables = ['featured_image'];

    }

Let's break it down. First we include the trait we're going to take advantage:

    use MikeFrancis\Uploadable\UploadableTrait;

Then in our model we use the trait:

    use UploadableTrait;

Our model's `$uploadables` is an array of file input name attributes which you'd like to be automatically handled by the trait.

It's as simple as that. Standby for more features coming soon!