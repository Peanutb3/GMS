import { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { Checkbox } from "@/components/ui/checkbox";
import { GraduationCap } from "lucide-react";

export default function Login() {
  const [formData, setFormData] = useState({
    username: "",
    password: "",
    rememberMe: false
  });
  const navigate = useNavigate();

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    // For testing - just navigate to dashboard
    navigate("/");
  };

  return (
    <div className="min-h-screen flex">
      {/* Left side - Login Form */}
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
                type="password"
                placeholder="Password"
                value={formData.password}
                onChange={(e) => setFormData({...formData, password: e.target.value})}
                className="bg-transparent border-b-2 border-white border-t-0 border-l-0 border-r-0 rounded-none text-white placeholder:text-white/70 focus:border-white focus:ring-0 pb-2"
              />
            </div>

            <div className="flex items-center space-x-2 mt-8">
              <Checkbox
                id="remember"
                checked={formData.rememberMe}
                onCheckedChange={(checked) => setFormData({...formData, rememberMe: !!checked})}
                className="border-white data-[state=checked]:bg-white data-[state=checked]:text-primary"
              />
              <label htmlFor="remember" className="text-white text-sm">
                Remember me
              </label>
            </div>

            <Button
              type="submit"
              className="w-full bg-white text-primary font-bold py-3 rounded-full hover:bg-white/90 transition-colors mt-8"
            >
              LOGIN
            </Button>
          </form>

          <p className="text-center text-white mt-8">
            Don't have an account?{" "}
            <Link to="/signup" className="underline hover:text-white/80">
              Sign up
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
              Welcome to the Grievance Monitoring System
            </h3>
            <p className="text-gray-600 text-sm">
              Streamline student grievance management and certificate processing
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