import { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { GraduationCap } from "lucide-react";

export default function Signup() {
  const [formData, setFormData] = useState({
    username: "",
    email: "",
    password: "",
    confirmPassword: "",
    role: ""
  });
  const navigate = useNavigate();

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    // For testing - just navigate to dashboard
    navigate("/");
  };

  return (
    <div className="min-h-screen flex">
      {/* Left side - Signup Form */}
      <div className="flex-1 bg-primary flex items-center justify-center p-8">
        <div className="w-full max-w-md">
          <div className="text-center mb-8">
            <h1 className="text-4xl font-bold text-white mb-2">Sign up</h1>
            <div className="w-16 h-1 bg-white mx-auto"></div>
          </div>

          <form onSubmit={handleSubmit} className="space-y-6">
            <div>
              <Input
                type="text"
                placeholder="Username"
                value={formData.username}
                onChange={(e) => setFormData({...formData, username: e.target.value})}
                className="bg-transparent border-b-2 border-white border-t-0 border-l-0 border-r-0 rounded-none text-white placeholder:text-white/70 focus:border-white focus:ring-0 pb-2"
              />
            </div>

            <div>
              <Input
                type="email"
                placeholder="Email"
                value={formData.email}
                onChange={(e) => setFormData({...formData, email: e.target.value})}
                className="bg-transparent border-b-2 border-white border-t-0 border-l-0 border-r-0 rounded-none text-white placeholder:text-white/70 focus:border-white focus:ring-0 pb-2"
              />
            </div>

            <div>
              <Select value={formData.role} onValueChange={(value) => setFormData({...formData, role: value})}>
                <SelectTrigger className="bg-transparent border-b-2 border-white border-t-0 border-l-0 border-r-0 rounded-none text-white focus:border-white focus:ring-0 pb-2">
                  <SelectValue placeholder="Select Role" className="text-white/70" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="student">Student</SelectItem>
                  <SelectItem value="staff">Staff</SelectItem>
                  <SelectItem value="admin">Admin</SelectItem>
                </SelectContent>
              </Select>
            </div>

            <div>
              <Input
                type="password"
                placeholder="New Password"
                value={formData.password}
                onChange={(e) => setFormData({...formData, password: e.target.value})}
                className="bg-transparent border-b-2 border-white border-t-0 border-l-0 border-r-0 rounded-none text-white placeholder:text-white/70 focus:border-white focus:ring-0 pb-2"
              />
            </div>

            <div>
              <Input
                type="password"
                placeholder="Confirm Password"
                value={formData.confirmPassword}
                onChange={(e) => setFormData({...formData, confirmPassword: e.target.value})}
                className="bg-transparent border-b-2 border-white border-t-0 border-l-0 border-r-0 rounded-none text-white placeholder:text-white/70 focus:border-white focus:ring-0 pb-2"
              />
            </div>

            <Button
              type="submit"
              className="w-full bg-white text-primary font-bold py-3 rounded-full hover:bg-white/90 transition-colors mt-8"
            >
              SIGN UP
            </Button>
          </form>

          <p className="text-center text-white mt-8">
            Already have an account?{" "}
            <Link to="/login" className="underline hover:text-white/80">
              Login
            </Link>
          </p>
        </div>
      </div>

      {/* Right side - Illustration */}
      <div className="flex-1 bg-gray-50 flex flex-col items-center justify-center p-8">
        <div className="text-center mb-8">
          <div className="flex items-center justify-center gap-4 mb-4">
            <div className="w-16 h-16 bg-primary rounded-full flex items-center justify-center">
              <GraduationCap className="h-8 w-8 text-white" />
            </div>
            <div className="text-left">
              <h2 className="text-2xl font-bold text-primary">GRIEVANCE</h2>
              <p className="text-sm text-gray-600">MONITORING SYSTEM</p>
            </div>
          </div>
        </div>

        {/* Illustration Area */}
        <div className="w-full max-w-md bg-white rounded-lg p-8 shadow-lg">
          <div className="text-center">
            <div className="w-32 h-32 bg-primary/10 rounded-full mx-auto mb-4 flex items-center justify-center">
              <GraduationCap className="h-16 w-16 text-primary" />
            </div>
            <h3 className="text-xl font-semibold text-gray-800 mb-2">
              Join the Grievance Monitoring System
            </h3>
            <p className="text-gray-600 text-sm">
              Create an account to access the system and manage grievances
            </p>
          </div>
        </div>

        <p className="text-center text-gray-500 text-xs mt-8">
          Copyright © 2024 University of Southeastern Philippines. All Rights Reserved
        </p>
      </div>
    </div>
  );
}