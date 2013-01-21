$.tablesorter.addParser({
  id: "bandwidth",
  is: function(s) {
    return false;
  },
  format: function(s) {
    // format your data for normalization
    switch (s.substr(-1)) {
      case "k":
        s = parseFloat(s);
      break;
      case "M":
        s = (parseFloat(s) * 1024);
      break;
      case "G":
        s = (parseFloat(s) * 1024 * 1024);
      break;
    }
    return s;
  },
  type: "numeric"
});

