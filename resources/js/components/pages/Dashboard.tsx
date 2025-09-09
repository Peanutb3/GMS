import { FileText, Users, GraduationCap, CheckCircle, Clock, AlertTriangle } from "lucide-react";
import { StatCard } from "@/components/dashboard/StatCard";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";

const Dashboard = () => {
  const stats = [
    {
      title: "Total Cases",
      value: "248",
      icon: <FileText className="h-8 w-8" />,
      trend: { value: 12, isPositive: true }
    },
    {
      title: "Active Cases", 
      value: "42",
      icon: <Clock className="h-8 w-8" />,
      trend: { value: 8, isPositive: false }
    },
    {
      title: "Resolved Cases",
      value: "206", 
      icon: <CheckCircle className="h-8 w-8" />,
      trend: { value: 15, isPositive: true }
    },
    {
      title: "Pending Reviews",
      value: "18",
      icon: <AlertTriangle className="h-8 w-8" />,
      trend: { value: 5, isPositive: false }
    }
  ];

  const recentGrievances = [
    {
      caseId: "CASE-2025-045",
      student: "Maria Santos",
      type: "Academic Misconduct",
      status: "Under Review",
      date: "2025-01-15",
      priority: "High"
    },
    {
      caseId: "CASE-2025-044", 
      student: "John Doe",
      type: "Harassment",
      status: "Investigation",
      date: "2025-01-14",
      priority: "Critical"
    },
    {
      caseId: "CASE-2025-043",
      student: "Sarah Johnson", 
      type: "Attendance Issues",
      status: "Resolved",
      date: "2025-01-13",
      priority: "Medium"
    },
    {
      caseId: "CASE-2025-042",
      student: "Mike Chen",
      type: "Behavioral Issues",
      status: "Open",
      date: "2025-01-12", 
      priority: "High"
    }
  ];

  const getStatusBadge = (status: string) => {
    const variants: Record<string, "default" | "secondary" | "destructive" | "outline"> = {
      "Resolved": "default",
      "Under Review": "secondary", 
      "Investigation": "destructive",
      "Open": "outline"
    };
    return <Badge variant={variants[status] || "outline"}>{status}</Badge>;
  };

  const getPriorityBadge = (priority: string) => {
    const colors: Record<string, string> = {
      "Critical": "bg-red-100 text-red-800",
      "High": "bg-orange-100 text-orange-800",
      "Medium": "bg-yellow-100 text-yellow-800",
      "Low": "bg-green-100 text-green-800"
    };
    return (
      <Badge className={colors[priority] || "bg-gray-100 text-gray-800"}>
        {priority}
      </Badge>
    );
  };

  return (
    <div className="space-y-6">
      {/* Welcome Section */}
      <div className="bg-gradient-to-r from-primary to-primary/80 rounded-lg p-6 text-primary-foreground">
        <div className="flex items-center justify-between">
          <div>
            <h2 className="text-2xl font-bold">Welcome back, Administrator!</h2>
            <p className="mt-2 text-primary-foreground/90">
              Monitor and manage all grievance cases across the university system.
            </p>
          </div>
          <div className="text-6xl opacity-20">
            <GraduationCap />
          </div>
        </div>
      </div>

      {/* Statistics Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {stats.map((stat, index) => (
          <StatCard key={index} {...stat} />
        ))}
      </div>

      {/* Recent Grievances */}
      <Card>
        <CardHeader>
          <CardTitle>Recent Grievance Cases</CardTitle>
          <CardDescription>
            Latest grievance reports that require attention
          </CardDescription>
        </CardHeader>
        <CardContent>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Case ID</TableHead>
                <TableHead>Student</TableHead>
                <TableHead>Type</TableHead>
                <TableHead>Status</TableHead>
                <TableHead>Priority</TableHead>
                <TableHead>Date</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {recentGrievances.map((grievance) => (
                <TableRow key={grievance.caseId} className="cursor-pointer hover:bg-muted/50">
                  <TableCell className="font-medium">{grievance.caseId}</TableCell>
                  <TableCell>{grievance.student}</TableCell>
                  <TableCell>{grievance.type}</TableCell>
                  <TableCell>{getStatusBadge(grievance.status)}</TableCell>
                  <TableCell>{getPriorityBadge(grievance.priority)}</TableCell>
                  <TableCell>{grievance.date}</TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </CardContent>
      </Card>

      {/* Quick Actions */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        <Card className="hover:shadow-md transition-shadow cursor-pointer">
          <CardContent className="p-6">
            <div className="flex items-center gap-4">
              <div className="p-3 bg-primary/10 rounded-lg">
                <Users className="h-6 w-6 text-primary" />
              </div>
              <div>
                <h3 className="font-semibold">Manage Staff</h3>
                <p className="text-sm text-muted-foreground">
                  Add, edit, or remove staff members
                </p>
              </div>
            </div>
          </CardContent>
        </Card>

        <Card className="hover:shadow-md transition-shadow cursor-pointer">
          <CardContent className="p-6">
            <div className="flex items-center gap-4">
              <div className="p-3 bg-primary/10 rounded-lg">
                <GraduationCap className="h-6 w-6 text-primary" />
              </div>
              <div>
                <h3 className="font-semibold">Manage Students</h3>
                <p className="text-sm text-muted-foreground">
                  View and manage student records
                </p>
              </div>
            </div>
          </CardContent>
        </Card>

        <Card className="hover:shadow-md transition-shadow cursor-pointer">
          <CardContent className="p-6">
            <div className="flex items-center gap-4">
              <div className="p-3 bg-primary/10 rounded-lg">
                <FileText className="h-6 w-6 text-primary" />
              </div>
              <div>
                <h3 className="font-semibold">Generate Reports</h3>
                <p className="text-sm text-muted-foreground">
                  Create comprehensive system reports
                </p>
              </div>
            </div>
          </CardContent>
        </Card>
      </div>
    </div>
  );
};

export default Dashboard;