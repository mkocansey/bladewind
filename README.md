<p><img src="https://img.shields.io/github/license/mkocansey/bladewind" alt="License" /></p><br />

## About BladewindUI

BladewindUI is a collection of UI components written purely using TailwindCSS, Laravel blade templates and Vanilla Javascript. These components are super simple to use and come with different levels of customization.
<br /><br />

### Installation
The full installatioin guide is available at Check out the full documentation on https://bladewindui.com.
<br />

BladewindUI is very specific to Laravel since all components are purely written using blade syntax. To install in your Laravel project simply run this command in the terminal at the root of your project.
<br /><br />

```
composer require mkocansey/bladewind
```
<br />

Next you need to **publish the package assets** by running this command, still in the terminal at the root of your Laravel project.

<br />

```
php artisan vendor:publish --provider="Mkocansey\Bladewind\BladewindServiceProvider" --tag=assets --force
```
<br />

Now include the BladewindUI css file and initialize a few javascript variables in the <head> of your pages. This should ideally be done in the layouts file your app's pages extend from.

<br />

```
<link href="{{ asset('bladewind/css/animate.min.css') }}" rel="stylesheet" />
```
```
<link href="{{ asset('bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
```

<br />

Finally, include the BladewindUI javascript file anywhere before the closing of the </body> tag of your pages. Again, this should ideally be done in the layouts file your app's pages extend from.

<br />

```
<script src="{{ asset('bladewind/js/helpers.js') }}" type="text/javascript"></script>
```

<br />

You are now ready to start using any of the BladewindUI components in your application

<br />

```
<x-bladewind.button> Save User </x-bladewind.button>
```

<br /><br />
### Components Include

- **[Alert](https://bladewindui.com/component/alert)**
- **[Avatar](https://bladewindui.com/component/avatar)**
- **[Button](https://bladewindui.com/component/button)**
- **[Card](https://bladewindui.com/component/card)**
- **[Centered Element](https://bladewindui.com/component/centered-element)**
- **[Checkbox](https://bladewindui.com/component/checkbox)**
- **[Datepicker](https://bladewindui.com/component/datepicker)**
- **[Dropdown](https://bladewindui.com/component/dropdown)**
- **[Empty State](https://bladewindui.com/component/empty-state)**
- **[Filepicker](https://bladewindui.com/component/filepicker)**
- **[Horizontal Line Graph](https://bladewindui.com/component/horizontal-line-graph)**
- **[List View](https://bladewindui.com/component/list-view)**
- **[Modal](https://bladewindui.com/component/modal)**
- **[Notification](https://bladewindui.com/component/notification)**
- **[Process Indicator](https://bladewindui.com/component/process-indicator)**
- **[Progress Bar](https://bladewindui.com/component/progress-bar)**
- **[Radio Button](https://bladewindui.com/component/radio-button)**
- **[Rating](https://bladewindui.com/component/rating)**
- **[Statistic](https://bladewindui.com/component/statistic)**
- **[Spinner](https://bladewindui.com/component/spinner)**
- **[Tab](https://bladewindui.com/component/tab)**
- **[Table](https://bladewindui.com/component/table)**
- **[Tag](https://bladewindui.com/component/tag)**
- **[Textbox](https://bladewindui.com/component/textbox)**
- **[Textarea](https://bladewindui.com/component/textarea)**
- **[Toggle](https://bladewindui.com/component/toggle)**

<br /><br />

Check out the full documentation on https://bladewindui.com.

<br /><br />

## Security Vulnerabilities

If you discover a security vulnerability, please e-mail Michael K. Ocansey at [kabutey@gmail.com](mailto:kabutey@gmail.com).

<br />

## License

BladewindUI components is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
