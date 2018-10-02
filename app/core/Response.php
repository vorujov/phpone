<?php 
namespace Core;

/**
 * Response Class
 */
class Response extends Data
{
    /**
     * Choose the proper echo function according to the $format
     * @param  string $format Output format. Defaults to "json"
     * @return null         
     */
    public function echo($format = "json")
    {
        switch ($format) {
            case "json":
                $this->echoJson();
                break;
            
            default:
                $this->echoJson();
                break;
        }
    }

    /**
     * Echo in json and jsonp format
     * @return [type] [description]
     */
    protected function echoJson()
    {
        $data = $this->data();

        $callback = Input::get("callback");
        if ($callback && preg_match('/[^a-z_\-0-9]/i', $callback)) {
            $callback = null;
        }

        echo $callback ? $callback . "(" . json_encode($data) . ")"
                       : json_encode($data);
        exit;
    }
}
