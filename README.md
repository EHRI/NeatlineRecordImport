# Neatline Record Import
 
Create Neatline Records for an exhibit via CSV data

The CSV must contain headers that correspond to record fields, e.g:

 - `title`
 - `body`
 - `slug`
 - `coverage` (WKT text)
 - `fill_color`
 - `fill_color_select`
 
Special handling for degree lat/lon values: if you omit coverage but include both `lat` and `lon` fields,
the coverage field will be set to the WKT value `POINT(lon_in_metres lat_in_meters)`.
