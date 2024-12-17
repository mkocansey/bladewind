<p><img src="https://img.shields.io/github/license/mkocansey/bladewind" alt="License" /></p><br />
<p><img src="https://github.com/mkocansey/bladewind-docs/blob/development/public/assets/images/bladewind-logo.png" style="height: 30px; margin-bottom:10px" /></p>

BladewindUI is a collection of UI components written purely using TailwindCSS, Laravel blade templates and Vanilla
Javascript. These components are super simple to use and come with different levels of customization.
<br /><br />

### Installation

The full installation guide is available on https://bladewindui.com/install.
<br />

BladewindUI is very specific to Laravel since all components are written purely using blade syntax. To install in your
Laravel project simply run this command in the terminal at the root of your project.
<br /><br />

```
composer require mkocansey/bladewind
```

<br />

Next you need to **publish the package assets** by running this command, still in the terminal at the root of your
Laravel project.

<br />

```
php artisan vendor:publish --provider="Mkocansey\Bladewind\BladewindServiceProvider" --tag=bladewind-public --force
```

<br />

Now include the BladewindUI css file in the &lt;head&gt; of your pages. This should ideally be done in the layouts file
your app pages extend from. You will also need to include the css used for animating the modals and other elements.

<br />

```
<link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
```

```
<link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
```

<br />

Finally, include the BladewindUI javascript file anywhere before the closing of the &lt;/body&gt; tag of your pages.
Again, this should ideally be done in the layouts file your app's pages extend from.

<br />

```
<script src="{{ asset('vendor/bladewind/js/helpers.js') }}" type="text/javascript"></script>
```

<br />

You are now ready to start using any of the BladewindUI components in your application

<br />

```
<x-bladewind::button>Save User</x-bladewind::button>
```

<br /><br />

### Components Include

- **[Accordion](https://bladewindui.com/component/accordion)**
- **[Alert](https://bladewindui.com/component/alert)**
- **[Avatar](https://bladewindui.com/component/avatar)**
- **[Bell](https://bladewindui.com/component/bell)**
- **[Button](https://bladewindui.com/component/button)**
- **[Card](https://bladewindui.com/component/card)**
- **[Centered Content](https://bladewindui.com/component/centered-content)**
- **[Checkbox](https://bladewindui.com/component/checkbox)**
- **[Datepicker](https://bladewindui.com/component/datepicker)**
- **[Dropdown](https://bladewindui.com/component/dropdown)**
- **[Dropmenu](https://bladewindui.com/component/dropmenu)**
- **[Empty State](https://bladewindui.com/component/empty-state)**
- **[Filepicker](https://bladewindui.com/component/filepicker)**
- **[Horizontal Line Graph](https://bladewindui.com/component/horizontal-line-graph)**
- **[Icon](https://bladewindui.com/component/icon)**
- **[Input](https://bladewindui.com/component/input)**
- **[List View](https://bladewindui.com/component/list-view)**
- **[Modal](https://bladewindui.com/component/modal)**
- **[Notification](https://bladewindui.com/component/notification)**
- **[Number](https://bladewindui.com/component/number)**
- **[Process Indicator](https://bladewindui.com/component/process-indicator)**
- **[Progress Bar](https://bladewindui.com/component/progress-bar)**
- **[Radio Button](https://bladewindui.com/component/radio-button)**
- **[Rating](https://bladewindui.com/component/rating)**
- **[Select](https://bladewindui.com/component/select)**
- **[Statistic](https://bladewindui.com/component/statistic)**
- **[Spinner](https://bladewindui.com/component/spinner)**
- **[Tab](https://bladewindui.com/component/tab)**
- **[Table](https://bladewindui.com/component/table)**
- **[Tag](https://bladewindui.com/component/tag)**
- **[Textarea](https://bladewindui.com/component/textarea)**
- **[Theme Switcher](https://bladewindui.com/component/theme-switcher)**
- **[Timeline](https://bladewindui.com/component/timeline)**
- **[Timepicker](https://bladewindui.com/component/timepicker)**
- **[Toggle](https://bladewindui.com/component/toggle)**
- **[Verification Code](https://bladewindui.com/component/verification-code)**

<br /><br />

Check out the full documentation on https://bladewindui.com.

<br /><br />

## Questions and General Info

If you want to ask anything at all or report a security vulnerability, please
e-mail [mike@bladewindui.com](mailto:mike@bladewindui.com) or tweet [@bladewindui](https://twitter.com/bladewindui)

<br />

## License

BladewindUI is an open-sourced library licensed under the [MIT license](https://opensource.org/licenses/MIT).
