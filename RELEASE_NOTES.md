# Release Notes - Development Merge to Main

*Released: August 24, 2025*

This release introduces improvements to the BladewindUI library, specifically focusing on the Select component's filtering behavior and Table component row interactivity. The changes enhance user experience through better component interaction and cleaner code architecture.

## Key Changes

### JavaScript: Select Component Filtering Enhancements

**Improved Filter Reset Logic**
- Added a `skipReset` property to the `BladewindSelect` class for granular control over component reset behavior during filtering operations
- Updated the `filter` method signature to accept a `skipReset` parameter (`filter(element, by = '', skipReset = true)`)
- Refactored the select logic to prevent unnecessary instantiation of related select components
- Eliminated the creation of new BladewindSelect instances during filtering (resolved FIXME comment)
- Improved filtering performance by consolidating reset operations

**Technical Improvements**
- Enhanced conditional logic in the `select` method to check `!this.skipReset` before triggering filter operations
- Moved reset logic directly into the filter method when `by !== ''` for more predictable behavior
- Cleaner separation of concerns between selection and filtering operations

### Blade Components: Enhanced User Interaction

**Select Component**
- Updated Blade template to pass the new `skipReset` parameter correctly (`filter('{{ $filter }}', '', false)`)
- Ensures proper reset behavior when filter relationships are established in the UI

**Table Component**
- Enhanced table row rendering with dynamic CSS classes using Laravel's `@class` directive
- Added `cursor-pointer` class automatically when `$onclick` is specified for better visual feedback
- Implemented clickable row functionality with `onclick` event handlers
- Cleaned up legacy commented code for improved readability
- Added row debugging capability with `@dump($row)` for development purposes

## User Experience Improvements

### Better Component Interaction
- **Select Components**: More responsive filtering with eliminated unnecessary resets and instantiations
- **Table Rows**: Improved visual feedback with pointer cursor when rows are clickable
- **Performance**: Reduced JavaScript overhead by eliminating redundant object creation during filtering

### Enhanced Accessibility
- Clear visual indication when table rows are interactive
- More predictable component behavior during filter operations
- Streamlined component lifecycle management

## Technical Details

### Files Modified
- `public/js/select.js` - Core filtering logic improvements
- `resources/views/components/select/index.blade.php` - Template parameter updates  
- `resources/views/components/table.blade.php` - Row interactivity enhancements

### Backward Compatibility
- All changes are backward compatible
- Existing Select component implementations will continue to work without modification
- New `skipReset` parameter defaults to `true` maintaining existing behavior

---

## About This Release

This release represents the merge of development branch improvements into main via **Pull Request #532**. The changes focus on code quality, performance optimization, and enhanced user interaction patterns.

**Repository**: [mkocansey/bladewind](https://github.com/mkocansey/bladewind)  
**Full Changelog**: [View on GitHub](https://github.com/mkocansey/bladewind/pull/532)

For more information about BladewindUI components, visit [bladewindui.com](https://bladewindui.com).