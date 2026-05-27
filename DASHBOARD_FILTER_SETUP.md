## Dashboard Filtering System - Complete Setup

### Files Created/Updated:

#### 1. **controllers/dashboard.controller.php** (NEW)
   - Single AJAX endpoint for all dashboard actions
   - Actions:
     - `search` - Filters properties and returns matching records with lat/lng
     - `getAll` - Returns all properties for initial map load
     - `getDetail` - Gets full property details by ID
   - Accepts filter parameters: type, location, storey, bedroom, tb, amenities, price range, etc.
   - Returns JSON with matching properties and marker data

#### 2. **models/dashboard.model.php** (UPDATED)
   - Already has `searchProperties()` method that handles filtering
   - Filters by: type, location, specs (storey, bedroom, T&B), amenities, price range
   - Returns only needed columns for map markers (lat, lng, name, price, etc.)

#### 3. **views/js/map.js** (UPDATED)
   - `filterProperties()` function now calls AJAX to controller
   - Collects all filter values from form
   - Sends to `/controllers/dashboard.controller.php?action=search`
   - Updates markers based on returned results
   - Auto-adjusts map view based on filtered results
   - `loadProperties()` now calls controller `getAll` endpoint

### How It Works:

1. **User selects filter** → SlimSelect onChange event
2. **User clicks Search** → Calls `window.filterProperties()`
3. **AJAX Request** → Sends all selected filters to controller
4. **Database Query** → Controller uses DashboardModel to search
5. **Results Returned** → JSON with matching properties
6. **Map Updated** → New markers appear at filtered property locations
7. **Map View Adjusted** → Zooms to show results

### Usage:

All filter logic is in ONE file: `dashboard.controller.php`
Just call this URL with filters:
```
/habitrack/controllers/dashboard.controller.php?action=search&type=House&bedroom=2&bathroom=1
```

Returns properties that match AND appear on map automatically!

### Supported Filters:
- type (House/Lot)
- location (City - Brgy)
- storey (1, 2, 3+)
- bedroom (1, 2, 3, 4+)
- tb (toilet/bathroom count)
- floorArea
- lotArea / sizeRange
- propertyName
- amenities (multiple)
- priceStart / priceEnd

