# Release v3.1.5

This release brings significant improvements to the select component's filtering behavior and enhances table interactivity, providing developers with better control and users with improved experience.

## Key Changes

### JavaScript: Select Component Filtering and Reset Logic

* **Enhanced Filtering Control:** Added a `skipReset` property to the `BladewindSelect` class to provide more granular control over when the select component resets during filtering operations.
* **Improved Method Signature:** Updated the `filter` method to accept a `skipReset` parameter, allowing developers to control reset behavior more precisely.
* **Performance Optimization:** Refactored the logic in the select component's `select` method to prevent unnecessary instantiation and resetting of related select components by utilizing the new `skipReset` flag.
* **Better Integration:** Updated Blade component usage to pass the new `skipReset` argument (`false`) when calling the `filter` method, ensuring correct reset behavior in the UI.

### Blade: Table Component Row Interactivity

* **Enhanced User Experience:** Table rows now include the `cursor-pointer` class and an `onclick` handler when the `$onclick` variable is set, making rows clearly clickable for better UX.
* **Improved Debugging:** Added a temporary `@dump($row)` statement for debugging purposes to help developers inspect row data during development.
* **Better Styling:** Rows now automatically receive appropriate visual feedback (pointer cursor) when they are interactive.

## Technical Details

### Files Modified
- `public/js/select.js` - Core select component JavaScript improvements
- `resources/views/components/select/index.blade.php` - Blade template updates for filter behavior
- `resources/views/components/table.blade.php` - Table component enhancements for row interactivity

### Developer Impact
- **Backward Compatible:** All changes maintain backward compatibility with existing implementations
- **Enhanced Control:** Developers now have finer control over select component reset behavior
- **Improved UX:** Table interactions are now more intuitive with visual feedback

## Migration Notes

No breaking changes were introduced in this release. Existing code will continue to work as expected. The new `skipReset` parameter is optional and defaults to maintain current behavior.

## What's Next

Future releases will continue to focus on:
- Enhanced component interactivity
- Performance optimizations
- Better developer experience
- Improved accessibility features

---

**Full Changelog:** [v3.1.4...v3.1.5](https://github.com/mkocansey/bladewind/compare/v3.1.4...v3.1.5)

**Pull Request:** [#532 - Merge Development into main](https://github.com/mkocansey/bladewind/pull/532)