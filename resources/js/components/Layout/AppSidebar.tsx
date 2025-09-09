import { useState } from "react";
import { 
  LayoutDashboard, 
  Users, 
  GraduationCap, 
  FileText, 
  History, 
  User, 
  Settings, 
  LogOut,
  Award
} from "lucide-react";
import { NavLink, useLocation } from "react-router-dom";

import {
  Sidebar,
  SidebarContent,
  SidebarGroup,
  SidebarGroupContent,
  SidebarGroupLabel,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
  SidebarTrigger,
  useSidebar,
} from "@/components/ui/sidebar";

const navigationItems = [
  { title: "Dashboard", url: "/", icon: LayoutDashboard },
  { title: "Manage Staff", url: "/staff", icon: Users },
  { title: "Manage Students", url: "/students", icon: GraduationCap },
  { title: "All Grievance Reports", url: "/grievances", icon: FileText },
  { title: "Good Moral Certificates", url: "/certificates", icon: Award },
  { title: "Action History", url: "/history", icon: History },
  { title: "Profile", url: "/profile", icon: User },
  { title: "Settings", url: "/settings", icon: Settings },
];

export function AppSidebar() {
  const { state } = useSidebar();
  const location = useLocation();
  const currentPath = location.pathname;

  const isCollapsed = state === "collapsed";

  return (
    <Sidebar
      className="bg-primary border-r-0"
      collapsible="icon"
    >
      <SidebarContent className="bg-primary">
        {/* Logo Section */}
        <div className="p-4 border-b border-primary-foreground/20">
          <div className="flex items-center gap-3">
            <div className="w-10 h-10 bg-primary-foreground rounded-full flex items-center justify-center">
              <GraduationCap className="h-6 w-6 text-primary" />
            </div>
            {!isCollapsed && (
              <div className="text-white">
                <h2 className="text-lg font-bold">GRIEVANCE</h2>
                <p className="text-xs text-white/80">MONITORING SYSTEM</p>
              </div>
            )}
          </div>
        </div>

        <SidebarGroup>
          <SidebarGroupContent>
            <SidebarMenu>
              {navigationItems.map((item) => (
                <SidebarMenuItem key={item.title}>
                  <SidebarMenuButton asChild>
                    <NavLink 
                      to={item.url} 
                      end 
                      className={({ isActive }) => `
                        flex items-center gap-3 px-3 py-2 rounded-md transition-colors
                        ${isActive 
                          ? "bg-white text-primary font-medium" 
                          : "text-white hover:bg-white/10 hover:text-white"
                        }
                      `}
                    >
                      <item.icon className="h-5 w-5" />
                      {!isCollapsed && <span>{item.title}</span>}
                    </NavLink>
                  </SidebarMenuButton>
                </SidebarMenuItem>
              ))}
            </SidebarMenu>
          </SidebarGroupContent>
        </SidebarGroup>

        {/* Logout Section */}
        <div className="mt-auto p-4 border-t border-primary-foreground/20">
          <SidebarMenuButton asChild>
            <button className="w-full flex items-center gap-3 px-3 py-2 rounded-md text-white hover:bg-white/10 hover:text-white transition-colors">
              <LogOut className="h-5 w-5" />
              {!isCollapsed && <span>Log out</span>}
            </button>
          </SidebarMenuButton>
        </div>
      </SidebarContent>
    </Sidebar>
  );
}