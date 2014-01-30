<?php namespace hunting;

class HuntingTest implements \qualicate\Test
{
    public function __construct()
    {
        $this->hunting_weeks = rand(3, 11);
    }

    public function description($post_url)
    {
        return <<<HTML
<form action="$post_url" method="post">
<p>If Andre Trudel goes hunting at least one Monday, Wednesday, or Friday every
week the hunting is good, and the hunting was good for $this->hunting_weeks
weeks last fall semester, at least how many COMP 1113 class sessions were
cancelled?</p>
<input type="text" name="hunting_weeks">
<input type="submit" value="Submit">
</form>
HTML;
    }

    public function validate($post)
    {
        return (isset($post['hunting_weeks'])
            && $post['hunting_weeks'] == $this->hunting_weeks);
    }

    public function successMessage()
    {
    }

    public function failureMessage()
    {
        return 'Obviously, you haven\'t been through 1113 nor have you been exposed to its lore.';
    }
}