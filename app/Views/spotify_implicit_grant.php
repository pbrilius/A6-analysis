<!DOCTYPE html>
<html>
    <script type="text/javascript">
        window.location='https://accounts.spotify.com/authorize?'
        + 'client_id=<?= getenv('CLIENT_ID'); ?>'
        + 'response_type=token&'
        + 'redirect_uri=<?= urlencode($redirectUrl) ?>&'
        + 'state="<?= $state ?>"';
    </script>
</html>