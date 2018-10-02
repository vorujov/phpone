<?php 
    /**
     * This is a temporary function used just in this file
     * It's being used to escape quotes for JS strings
     * @param  string $string 
     * @return string         
     */
    function __jsf($string)
    {
        return str_replace("'", "\'", $string);
    }
?>
<script type="text/javascript" charset="utf-8">
    var __ = function(msgid) 
    {
        return window.i18n[msgid] || msgid;
    };

    window.i18n = {
        'generic_error_message': '<?= __jsf(__("Oops! Something went wrong. Please try again later.")) ?>',
    };
</script>