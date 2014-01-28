<?php namespace qualicate;

interface Test
{
    /**
     * @param string $post_url the URL the test should POST to
     * @return string an HTML description of the test including input form
     */
    public function description($post_url);

    /**
     * @param array $post POSTed data; may or may not be relevant
     * @return boolean whether or not the user response was correct
     */
    public function validate($post);

    /**
     * Get the message to be shown to the user when they pass the test. If
     * nothing is returned or the returned value is equivalent to the empty
     * string, and the test has not been configured such that it is the last
     * test in the series, the user is immediately forwarded to the next test.
     *
     * @return string the message to display to the user upon their success
     */
    public function successMessage();

    /**
     * @return string the message to display to the user upon their failure
     */
    public function failureMessage();
}
