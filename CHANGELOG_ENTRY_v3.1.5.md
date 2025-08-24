## [3.1.5] - 2025-08-24

### Added
- `skipReset` property to BladewindSelect class for granular filtering control
- Enhanced table row interactivity with automatic cursor-pointer styling
- Support for onclick handlers in table rows when `$onclick` variable is set
- Debugging capabilities with temporary row data inspection in table component

### Changed
- Updated `filter` method signature in BladewindSelect to accept optional `skipReset` parameter
- Improved select component logic to prevent unnecessary resets during filtering
- Enhanced Blade template integration for select component filtering behavior
- Table rows now provide better visual feedback for interactive elements

### Fixed
- Optimized select component performance by avoiding unnecessary instantiations
- Improved reset behavior control in related select components

### Technical Details
- Modified `public/js/select.js` (8 additions, 6 deletions)
- Updated `resources/views/components/select/index.blade.php` (1 addition, 1 deletion)  
- Enhanced `resources/views/components/table.blade.php` (6 additions, 4 deletions)

### Developer Impact
- All changes maintain backward compatibility
- No migration required for existing implementations
- New optional parameters provide enhanced control without breaking existing code

### Links
- Pull Request: [#532](https://github.com/mkocansey/bladewind/pull/532)
- Commit: [15ef279](https://github.com/mkocansey/bladewind/commit/15ef279f3311e63f1cc21f96467dccccf83ca186)