$(document).ready(function () {
  $("#registerForm").validate();
  $("#eventCreateForm").validate();

  $("#eventsTable").DataTable();
  $("#attendeeTable").DataTable();

  let table = $("#eventDashboardTable").DataTable({
    processing: true,
    serverSide: false,
    ajax: {
      url: "get-events.php", // API endpoint
      type: "GET",
      data: function (d) {
        d.name = $("#searchName").val();
        d.location = $("#searchLocation").val();
        d.start_date = $("#startDate").val();
        d.end_date = $("#endDate").val();
      },
    },

    columns: [
      { data: "id" },
      { data: "name" },
      { data: "description" },
      { data: "event_date" },
      { data: "location" },
      { data: "capacity" },
      {
        data: "id",
        render: function (data) {
          return `<a href="event-view.php?id=${data}" class="btn btn-info btn-sm">View</a> 
                        <a href="export-attendees-report.php?event_id=${data}" class="btn btn-warning btn-sm">Download Report</a> 
                        `;
        },
      },
    ],
  });

     // Apply filters on input change
     $('#searchName, #searchLocation, #startDate, #endDate').on('keyup change', function () {
        table.ajax.reload();
    });

    // Reset filters
    $('#resetFilters').click(function () {
        $('#searchName, #searchLocation, #startDate, #endDate').val('');
        table.ajax.reload();
    });
});
