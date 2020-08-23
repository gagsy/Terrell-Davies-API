import React from "react";
import { Redirect } from "react-router-dom";

// Layout Types
import { DefaultLayout } from "./layouts";

// Route Views
import Dashboard from "./views/Dashboard";
import AdminProfile from "./views/AdminProfile";
import Settings from "./views/Settings";
import Agents from "./views/Agents";
import Errors from "./views/Errors";
import Properties from "./views/Properties";
import AddNewProperty from "./views/AddNewProperty";
import PropertyFeature from "./views/PropertyFeature";
import PropertyStatus from "./views/PropertyStatus";
import PropertyTypes from "./views/PropertyTypes";


export default [
  {
    path: "/admin",
    exact: true,
    layout: DefaultLayout,
    component: () => <Redirect to="/admin/dashboard" />
  },
  {
    path: "/admin/dashboard",
    exact: true,
    layout: DefaultLayout,
    component: Dashboard
  },
  {
    path: "/admin/properties",
    exact: true,
    layout: DefaultLayout,
    component: Properties
  },
  {
    path: "/admin/add-property",
    layout: DefaultLayout,
    component: AddNewProperty
  },
  {
    path: "/admin/property-features",
    layout: DefaultLayout,
    component: PropertyFeature
  },
  {
    path: "/admin/property-status",
    layout: DefaultLayout,
    component: PropertyStatus
  },
  {
    path: "/admin/property-types",
    layout: DefaultLayout,
    component: PropertyTypes
  },
  {
    path: "/admin/admin-profile",
    layout: DefaultLayout,
    component: AdminProfile
  },
  {
    path: "/admin/agents",
    layout: DefaultLayout,
    component: Agents
  },
  {
    path: "/admin/settings",
    layout: DefaultLayout,
    component: Settings
  },
  {
    path: "/admin/errors",
    layout: DefaultLayout,
    component: Errors
  },
];
