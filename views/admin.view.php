<div class='wrap' style='padding-bottom: 20px;'>
    <h1>Minimalist Assets CDN Plugin</h1>

    <?php if ($updated): ?>
        <div class='update-nag notice notice-success' style='width:95%'>
            CDN settings have been updated.
        </div>
    <?php endif; ?>

    <!-- Ah wordpress, tables for layouts like it's the 90s ... -->
    <form method='POST'>
        <table class='form-table' width='100%'>
            <tbody>
                <tr>
                    <th><label for='cdn'>CDN Url</label></th>
                    <td>
                        <input id='cdn' name='data[cdn]' type='text' maxlength='255' value='<?= $this->_cdn ?>' class='regular-text ltr'/>
                        <p><em>Full path with protocol for your CDN, for example: <code>https://your.cdn.com</code></em></p>
                        <p><strong>Note:</strong> To disable the CDN, you can disable the plugin or empty this field.</p>
                    </td>
                </tr>
                <tr>
                    <th><label for='admin'>Enable CDN for WP Admin</label></th>
                    <td>
                        <select id='admin' name='data[admin]'>
                            <option value='0'>Disabled</option>
                            <option value='1' <?= $this->_admin ? 'selected="selected"' : '' ?>>Enabled</option>
                        </select>
                        <p><strong>Warning:</strong> If the CDN path is invalid, the Wordpress admin could break (except for this page).</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <button type='submit' class='button-primary'>Update Settings</button>
    </form>
</div>

<?php if (!empty($this->_cdn)): ?>
<hr/>

<div class='wrap'>

<h1>Developer Tools</h1>
<p>If you're writing a custom plugin and you wish to use the URL parser included in this plugin you can use the <code><?= "{$this->_wpFilterNamespace}_format" ?></code> filter. Note that this custom filter isn't required when using standard wordpress enqueue functions.</p>

<h2>Example</h2>

<h4>Code:</h4>

<pre>
$url = '/wp-content/themes/your-theme/js/entrypoint.js';
$url = apply_filters('<?= "{$this->_wpFilterNamespace}_format" ?>', $url);
echo $url;
</pre>


<h4>Output:</h4>
<pre>
<?= apply_filters("{$this->_wpFilterNamespace}_format", 'https://www.domain.com/wp-content/themes/your-theme/js/entrypoint.js', true); ?>
</pre>

</div>

<?php endif; ?>
