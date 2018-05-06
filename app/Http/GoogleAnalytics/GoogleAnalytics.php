<?php
namespace App\Http\GoogleAnalytics;

// Load the Google API PHP Client Library.
//require_once '../vendor/autoload.php';

use Google_Client;
use Google_Service_AnalyticsReporting;
use Google_Service_AnalyticsReporting_DateRange;
use Google_Service_AnalyticsReporting_Metric;
use Google_Service_AnalyticsReporting_Dimension;
use Google_Service_AnalyticsReporting_ReportRequest;
use Google_Service_AnalyticsReporting_GetReportsRequest;
use Google_Service_AnalyticsReporting_OrderBy;
use Google_Service_AnalyticsReporting_DimensionFilter;
use Google_Service_AnalyticsReporting_DimensionFilterClause;

class Analytics
{

    public static function initializeAnalytics()
    {
        $KEY_FILE_LOCATION = __DIR__ . '/client_secrets.json';
        $client = new Google_Client();
        $client->setApplicationName("Cloudstore Google Analytics Reporting");
        $client->setAuthConfig($KEY_FILE_LOCATION);
        $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
        $analytics = new Google_Service_AnalyticsReporting($client);

        return $analytics;
    }



    public static function getReport($analytics, $VIEW_ID, array $date_ranges, $store_domain) {
        $date1 = new Google_Service_AnalyticsReporting_DateRange();
        $date1->setStartDate($date_ranges[0]);
        $date1->setEndDate($date_ranges[1]);


        // Sessions metric object.
        $sessions = new Google_Service_AnalyticsReporting_Metric();
        $sessions->setExpression("ga:sessions");
        $sessions->setAlias("sessions");


        // Pageviews metric object.
        $pageviews = new Google_Service_AnalyticsReporting_Metric();
        $pageviews->setExpression("ga:pageviews");
        $pageviews->setAlias("pageviews");


        // Dates dimension object.
        $dates = new Google_Service_AnalyticsReporting_Dimension();
        $dates->setName("ga:date");


        // Pagepath dimension object.
        $pagepath = new Google_Service_AnalyticsReporting_Dimension();
        $pagepath->setName("ga:pagepath");



        // City dimension object.
        $city = new Google_Service_AnalyticsReporting_Dimension();
        $city->setName("ga:city");


        // Create the DimensionFilter.
        $dimensionFilter = new Google_Service_AnalyticsReporting_DimensionFilter();
        $dimensionFilter->setDimensionName('ga:hostname');
        $dimensionFilter->setOperator('EXACT');
        $dimensionFilter->setExpressions([$store_domain]);


        // Create the DimensionFilterClauses
        $dimensionFilterClause = new Google_Service_AnalyticsReporting_DimensionFilterClause();
        $dimensionFilterClause->setFilters(array($dimensionFilter));

        // Set Order
        $ordering = new Google_Service_AnalyticsReporting_OrderBy();
        $ordering->setFieldName("ga:date");
        $ordering->setOrderType("VALUE");   
        $ordering->setSortOrder("DESCENDING");


        // Create the ReportRequest object.
        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($VIEW_ID);
        $request->setDateRanges([$date1]);
        $request->setMetrics([$sessions, $pageviews]);
        $request->setDimensions([$dates, $pagepath, $city]);
        $request->setDimensionFilterClauses([$dimensionFilterClause]);
        $request->setOrderBys($ordering);
        $request->setIncludeEmptyRows(true);

        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests( array( $request) );
        return $analytics->reports->batchGet( $body );
    }






  public static function getResults($reports) {
    $results = [];
    for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
      $report = $reports[ $reportIndex ];
      $header = $report->getColumnHeader();
      $dimensionHeaders = $header->getDimensions();
      $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
      $rows = $report->getData()->getRows();

      for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
        $row = $rows[ $rowIndex ];
        $dimensions = $row->getDimensions();
        $metrics = $row->getMetrics();
        for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
          $results[] = $dimensions[$i];
          //print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
        }

        for ($j = 0; $j < count($metrics); $j++) {
          $values = $metrics[$j]->getValues();
          for ($k = 0; $k < count($values); $k++) {
            $entry = $metricHeaders[$k];
            $results[] = $values[$k];
            //print($entry->getName() . ": " . $values[$k] . "\n");
          }
        }
      }
    }
    return $results;
  }


}
