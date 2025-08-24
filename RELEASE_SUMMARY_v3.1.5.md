# BladewindUI v3.1.5 - Release Summary

## Overview
Bug fixes and feature enhancements for select component filtering and table row interactivity.

## Key Features
1. **Select Component:** Added `skipReset` parameter for better filtering control
2. **Table Component:** Enhanced row interactivity with onclick handlers and cursor styling

## Developer Benefits
- More granular control over select component reset behavior
- Improved table UX with visual feedback for clickable rows
- Better debugging capabilities for table data inspection
- Maintained full backward compatibility

## Statistics
- **3 files modified**
- **15 total additions, 11 deletions**
- **Zero breaking changes**

## Quick Integration
The new features work automatically with existing code. For advanced use cases:

```javascript
// New optional skipReset parameter
selectInstance.filter('targetElement', 'filterValue', false);
```

```php
<!-- Enhanced table rows with onclick support -->
<x-bladewind::table onclick="handleRowClick(row)" />
```

## Related
- **PR:** #532 - Merge Development into main  
- **Previous Release:** v3.1.4
- **Next Release:** TBD

---

*Generated from the latest merged PR into main branch*