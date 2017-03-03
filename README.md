# wp-google-pagespeed-api
A WordPress php library for interacting with the [Google PageSpeed API](https://developers.google.com/speed/docs/insights/v2/reference/pagespeedapi/runpagespeed).

[![Code Climate](https://codeclimate.com/repos/57d32a493ed8c24d320013c7/badges/531d616e40b6562c89da/gpa.svg)](https://codeclimate.com/repos/57d32a493ed8c24d320013c7/feed)
[![Test Coverage](https://codeclimate.com/repos/57d32a493ed8c24d320013c7/badges/531d616e40b6562c89da/coverage.svg)](https://codeclimate.com/repos/57d32a493ed8c24d320013c7/coverage)
[![Issue Count](https://codeclimate.com/repos/57d32a493ed8c24d320013c7/badges/531d616e40b6562c89da/issue_count.svg)](https://codeclimate.com/repos/57d32a493ed8c24d320013c7/feed)

## Usage

```php
$google_pagespeed = new GooglePageSpeedAPI('YOUR-API-KEY');

$pagespeed_results = $google_pagespeed->run_pagespeed( 'YOUR-URL-TO-BE-TESTED' );
```
