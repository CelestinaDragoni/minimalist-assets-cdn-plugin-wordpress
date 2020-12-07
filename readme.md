# Minimalist Assets CDN Plugin for Wordpress
Simple Wordpress plugin that enables a CDN url for your enqueued styles and scripts throughout your site. This is completely free and can be white labeled as needed.

## Requirements
- Wordpress Installed (Versions untested, but this was tested on the latest).
- PHP 7.0+ (Should work on 5.6, but you shouldn't be running it)

## Installation
- Drop this bad boi into your `/wp-content/plugins` folder.
- Enable in your plugin settings.
    - For multisite, you can network enable this if you so desire.
- From the WP admin sidebar go to `Settings` and then `Minimalist Assets CDN` and add your configuration changes there.

## For Theme/Plugin Developers
Once you have enabled the plugin **Developer Tools** will show on the settings page giving a demo. However, included is a filter for you to use if you need extra CDNing outside of the standard `wp_enqueue_script` and `wp_enqueue_style` functions. The `kz_minimalist_assets_cdn_filter` will allow you to parse any URL and convert it into a CDN url.

### Example

CDN Url = `https://yourcdn.cloudflare.com`

#### Code:
```
$url = '/wp-content/themes/your-theme/js/entrypoint.js';
$url = apply_filters('kz_minimalist_assets_cdn_format', $url);
echo $url;
```
#### Output:
```
https://yourcdn.cloudflare.com/wp-content/themes/your-theme/js/entrypoint.js
```
## Support
There is none, it's a simple class that is well documented. If it doesn't work for you modify it to your hearts content.

## License
Copyright 2020 Anthony Mattera (KernelZechs, https://github.com/KernelZechs)

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.

2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

3. Neither the name of the copyright holder nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
