export default function() {
  return [
    {
      title: "Dashboard",
      to: "/admin/dashboard",
      htmlBefore: '<i class="material-icons">dashboard</i>',
      htmlAfter: ""
    },
    {
      title: "Properties",
      htmlBefore: '<i class="material-icons">house</i>',
      to: "/admin/properties",
    },
    {
      title: "Features",
      htmlBefore: '<i class="material-icons">vertical_split</i>',
      to: "/admin/property-features",
    },
    {
      title: "Status",
      htmlBefore: '<i class="material-icons">vertical_split</i>',
      to: "/admin/property-status",
    },
    {
      title: "Types",
      htmlBefore: '<i class="material-icons">vertical_split</i>',
      to: "/admin/property-types",
    },
  
    {
      title: "Agents",
      htmlBefore: '<i class="material-icons">person</i>',
      to: "/admin/agents",
    },
    {
      title: "Settings",
      htmlBefore: '<i class="material-icons">settings</i>',
      to: "/admin/settings",
    },
  ];
}
