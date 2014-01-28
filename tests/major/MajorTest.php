<?php namespace major;

class MajorTest implements \qualicate\Test
{
    public function description($post_url)
    {
        return <<<HTML
<form action="$post_url" method="post">
<p>What is your major?</p>
<select name="major">
<option value="wrong">Not Computer Science</option>
<option value="right">Computer Science</option>
<input type="submit" value="Submit">
</select>
</form>
HTML;
    }

    public function validate($post)
    {
        /* Yes, this is deeply succeptable to end-user manipulation. We
         * don't care. If they're the sort of person to be able to do that
         * sort of manipulation, they can get in just fine. */
        return (isset($post['major']) && $post['major'] === 'right');
    }

    public function successMessage()
    {
    }

    public function failureMessage()
    {
        return 'This is not for you. Leave this place, and do not return.';
    }
}