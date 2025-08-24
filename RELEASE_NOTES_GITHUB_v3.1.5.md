# Release v3.1.5

This release enhances the select component's filtering behavior and improves table row interactivity for a better developer and user experience.

## 🚀 Features & Improvements

### Select Component Enhancements
- Added `skipReset` property for granular control over filtering reset behavior
- Updated `filter` method signature to accept optional `skipReset` parameter  
- Optimized select component logic to prevent unnecessary resets and instantiations
- Improved Blade template integration with new filtering parameters

### Table Component Improvements
- Enhanced table rows with automatic `cursor-pointer` styling for clickable rows
- Added `onclick` handler support when `$onclick` variable is provided
- Better visual feedback for interactive table elements
- Added debugging capabilities with temporary row data inspection

## 🔧 Technical Changes

**Modified Files:**
- `public/js/select.js` - Core filtering and reset logic improvements
- `resources/views/components/select/index.blade.php` - Template updates for new filter behavior
- `resources/views/components/table.blade.php` - Enhanced row interactivity

## ✅ Backward Compatibility

All changes are fully backward compatible. Existing implementations will continue to work without modification. The new `skipReset` parameter is optional and maintains current behavior by default.

## 📊 Impact

- **+8 additions, -6 deletions** in JavaScript components
- **+1 addition, -1 deletion** in Blade templates  
- **+6 additions, -4 deletions** in table components
- **Total: 3 files changed**

---

**For more details, see:** [PR #532](https://github.com/mkocansey/bladewind/pull/532)