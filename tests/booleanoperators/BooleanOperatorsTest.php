<?php namespace booleanoperators;

class BooleanOperatorsTest implements \qualicate\Test
{
    const PARAMETER_SETS = 4;

    private $example;
    private $parameters = [];
    private $concatenation = '';

    public function __construct()
    {
        for ($i = 0; $i < self::PARAMETER_SETS; $i++)
            $this->example .= rand(0, 1);

        if (isset($_SESSION['bot_parameters'])
            && isset($_SESSION['bot_concatenation']))
        {
            $this->parameters = $_SESSION['bot_parameters'];
            $this->concatenation = $_SESSION['bot_concatenation'];
            return;
        }

        for ($i = 0; $i < self::PARAMETER_SETS; $i++)
        {
            $p = rand(0, 1);
            $q = rand(0, 1);
            $r = rand(0, 1);
            $s = rand(0, 1);
            $this->parameters[] = [$p, $q, $r, $s];
            $this->concatenation .= (int) self::f($p, $q, $r, $s);
        }
        $_SESSION['bot_parameters'] = $this->parameters;
        $_SESSION['bot_concatenation'] = $this->concatenation;
    }

    public function description($post_url)
    {
        $description = <<<HTML
<p>Given the function</p>
<blockquote><em>f</em>(<em>p</em>, <em>q</em>, <em>r</em>, <em>s</em>) =
((<em>r</em> &and; <em>q</em>) &or; (<em>p</em> &and; &not;<em>s</em>)) &or;
(&not;<em>p</em> &and; &not;<em>r</em> &and; &not;<em>s</em>)</blockquote>
<p>enter the concatenation of the results of <em>f</em>(<em>p</em>, <em>q</em>,
<em>r</em>, <em>s</em>) for the following values of <em>p</em>, <em>q</em>,
<em>r</em>, <em>s</em>:</p>
<table border="1">
    <thead>
        <tr>
            <th>p</th>
            <th>q</th>
            <th>r</th>
            <th>s</th>
        </tr>
    </thead>
    <tbody>

HTML;

        foreach ($this->parameters as $parameter_set)
        {
            $description .= <<<HTML
        <tr>
            <td>$parameter_set[0]</td>
            <td>$parameter_set[1]</td>
            <td>$parameter_set[2]</td>
            <td>$parameter_set[3]</td>
        </tr>

HTML;
        }

        $description .= <<<HTML
    </tbody>
</table>
<form action="$post_url" method="post">
<input type="text" name="concatenation" placeholder="Example: $this->example">
<input type="submit" value="Submit">
</form>
<!-- The answer is $this->concatenation. -->

HTML;

        return $description;
    }

    private static function f($p, $q, $r, $s)
    {
        return (($r && $q) || ($p && !$s)) || (!$p && !$r && !$s);
    }

    public function validate($post)
    {
        return (isset($_POST['concatenation'])
            && $_POST['concatenation'] == $this->concatenation);
    }

    public function successMessage()
    {
    }

    public function failureMessage()
    {
        return 'That was technically incorrect: the worst kind of incorrect.';
    }
}