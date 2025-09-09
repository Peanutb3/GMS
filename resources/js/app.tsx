import React from "react";
import ReactDOM from "react-dom/client";
import "../css/app.css"; // Tailwind import

// Providers and utilities
import { Toaster } from "@/components/ui/toaster";
import { Toaster as Sonner } from "@/components/ui/sonner";
import { TooltipProvider } from "@/components/ui/tooltip";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import { SidebarProvider } from "@/components/ui/sidebar";

// Layout
import { AppSidebar } from "@/components/layout/AppSidebar";
import { Header } from "@/components/layout/Header";

// Pages
import Dashboard from "@/pages/Dashboard";
import Staff from "@/pages/Staff";
import Students from "@/pages/Students";
import Grievances from "@/pages/Grievances";
import Certificates from "@/pages/Certificates";
import Login from "@/pages/Login";
import Signup from "@/pages/Signup";
import NotFound from "@/pages/NotFound";

// Create QueryClient
const queryClient = new QueryClient();

// Main App component
const App = () => (
  <QueryClientProvider client={queryClient}>
    <TooltipProvider>
      <Toaster />
      <Sonner />
      <BrowserRouter>
        <SidebarProvider>
          <div className="min-h-screen flex w-full">
            <AppSidebar />
            <div className="flex-1 flex flex-col">
              <Header />
              <main className="flex-1 p-6 bg-background">
                <Routes>
                  <Route path="/login" element={<Login />} />
                  <Route path="/signup" element={<Signup />} />
                  <Route path="/" element={<Dashboard />} />
                  <Route path="/staff" element={<Staff />} />
                  <Route path="/students" element={<Students />} />
                  <Route path="/grievances" element={<Grievances />} />
                  <Route path="/certificates" element={<Certificates />} />
                  <Route path="*" element={<NotFound />} />
                </Routes>
              </main>
            </div>
          </div>
        </SidebarProvider>
      </BrowserRouter>
    </TooltipProvider>
  </QueryClientProvider>
);

// Render App into Blade’s <div id="app">
ReactDOM.createRoot(document.getElementById("app") as HTMLElement).render(
  <App />
);