var SplashScreen = (function () {
  'use strict';

  function animate($splashScreenElement) {
    var duration = 1000;

    setTimeout(function () {
      $splashScreenElement.fadeOut();
    }, duration);
  }

  return {
    init: function () {
      animate($('[splash-screen]'));
    }
  };
}());


var AlarmTable = (function () {
  'use strict';

  var fields = ['alarm_id', 'position', 'result', 'time'];
  var filterQuery = { field: undefined, value: undefined };
  var $containerElement;

  function filter(element) {
    var field = filterQuery.field;
    var value = filterQuery.value;

    if (field && value) {
      var targetElement = element.querySelector('[field=' + field + ']');
      if (targetElement.textContent !== value) {
        $(element).fadeOut();
        return;
      }
    }
    $(element).fadeIn();
  }

  function createRowElement(data) {
    var trElement = document.createElement('tr');
    trElement.className += "alarm-row";
    trElement.setAttribute('id', data['alarm_id']);
    trElement.setAttribute('onclick', 'openDetail('+data['alarm_id']+')');
    if (data['result'] == "Stop") {
      trElement.className += " alarm-tr-warnning";
    }
    else {
      trElement.className += " alarm-tr-clear";
    }

    var time = data['time_updated'].split(/[- :]/);
    var dateTime = new Date(time[0], time[1]-1, time[2], time[3], time[4], time[5]);

    fields.forEach(function (field) {
      var tdElement = document.createElement('td');
      tdElement.setAttribute('field', field);
      if (field == "time") {
        tdElement.textContent = data['time_updated'];//timeDifference(Date.now(), dateTime);
      }
      else {
        tdElement.textContent = data[field];
      }
      trElement.appendChild(tdElement);
    });

    trElement.style.display = 'none';
    return trElement;
  }

  return {
    init: function () {
      $containerElement = $('[alarm-table] tbody');
      console.log($containerElement);
    },

    prepend: function (data) {
      var rowElement = createRowElement(data);
      $containerElement.prepend(rowElement);
      filter(rowElement);
    },

    append: function (data) {
      var rowElement = createRowElement(data);
      $containerElement.append(rowElement);
      filter(rowElement);
    },

    filter: function (field, value) {
      filterQuery.field = field;
      filterQuery.value = value;

      var $elements = $containerElement.children();
      $elements.each(function (index, element) {
        filter(element);
      });
    }
  };
}());


var AlarmManager = (function (AlarmTable) {
  'use strict';

  var offset = 0;
  var last_id = '';
  var last_time_updated = '';
  var loading = false;

  function isScrollAtBottom() {
    var windowHeight = window.innerHeight;
    var scrollHeight = document.body.scrollHeight;
    var scrollTop = document.body.scrollTop;
    return scrollTop + windowHeight === scrollHeight;
  }

  function runner(context, callback) {
    var duration = 200;
    var id = setInterval(function () {
      callback();
      if (this.finished) clearInterval(id);
    }.bind(context), duration);
  }

  function loadNew() {
    if (loading) return;
    loading = true;

    $.get('/loadnewalarm', { last_id: last_id, last_time_updated: last_time_updated }, function (data) {
      var context = {};
      if (data.length) {
        last_id = data[0]['alarm_id'];
        last_time_updated = data[0]['time_updated'];
        offset += data.length;
      }
      runner(context, function () {
        if (data.length) {
          var tmp = data.shift();
          AlarmTable.prepend(tmp);
          console.log(tmp);
          if (tmp['result'] == "Stop") {
            Materialize.toast("[NEW ALARM] !! STOP "+tmp['position'], 7000, 'rounded');
          }
          else {
            Materialize.toast("[NEW ALARM] !! START "+tmp['position'], 7000, 'rounded');
          }
          context.finished = !data.length;
        }
      });
      loading = false;
    });
  }

  function loadMore() {
    if (loading) return;
    loading = true;

    $.get('/loadalarmmore', { offset: offset }, function (data) {
      var context = {};
      if (offset == 0) {
        last_id = data[0]['alarm_id'];
        last_time_updated = data[0]['time_updated'];
      }
      offset += 10;
      runner(context, function () {
        AlarmTable.append(data.shift());
        context.finished = !data.length;
      });
      loading = false;
    });
  }

  return {
    init: function () {
      $('[alarm-table-more]').click(loadMore); 

      window.addEventListener('scroll', function () {
        if (isScrollAtBottom()) loadMore();
      });

      loadMore();
      setInterval(loadNew, 5000);
    }
  };
}(AlarmTable));


document.addEventListener('DOMContentLoaded', function () {
  AlarmTable.init();
  AlarmManager.init();
  detailTable.init();
  SplashScreen.init();
});

var detailTable = (function () {
  'use strict';

  var actualPosition = ['node-name', 'rack-number', 'card-number', 'port-number', 'splitter1-number', 'splitter2-number'];
  var $tableElement;

  function createRowElement(data) {
    var trElement = document.createElement('tr');
    var tdElement = document.createElement('td');
    tdElement.setAttribute('field', 'customer-id');
    tdElement.textContent = data['cust_id'];
    trElement.appendChild(tdElement);
    tdElement = document.createElement('td');
    tdElement.setAttribute('field', 'time');
    tdElement.textContent = data['time_started'];
    trElement.appendChild(tdElement);
    tdElement = document.createElement('td');
    tdElement.setAttribute('field', 'status');
    tdElement.textContent = "";
    trElement.appendChild(tdElement);  
    return trElement;
  }

  return {
    init: function() {
      $tableElement = $('[customer-table] tbody'); 
    },

    loadvalue: function(id) {
      $.get('/loaddetail', { alarm_id : id }, function (data) {
        $("#service-type").val(data['service_type']);
        $("#alarm-type").val(data['result'])
        var position = data['position'].split(" ");
        var actualPosition = ['node-name', 'rack-number', 'card-number', 'port-number', 'splitter1-number', 'splitter2-number'];
        position.forEach(function (p,i) {
          $("#"+actualPosition[i]).val(p);
        });

        data['customer_list'].forEach(function (c) {
          var rowElement = createRowElement(c);
          $tableElement.append(rowElement);
        });
      });
    },

    clear: function() {
      $("#service-type").val(" ");
      $("#alarm-type").val(" ");
      $("#node-name").val(" ");
      $("#rack-number").val(" ");
      $("#card-number").val(" ");
      $("#port-number").val(" ");
      $("#splitter1-number").val(" ");
      $("#splitter2-number").val(" ");
      $tableElement.empty();
    }

  };

}());

function openDetail(id) {
  detailTable.clear();
  detailTable.loadvalue(id);
  $("#modal1").openModal();
}

/*
$(".test").click(function(){
  AlarmTable.filter('result', 'Start');
});
*/

$(".alarm-row").click(function() {
  console.log(5555);
    $('#modal1').openModal();

});