import { useState } from "react";
import { Search, Filter, Plus, MoreHorizontal, Eye, Edit, MessageSquare } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from "@/components/ui/badge";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";

const Grievances = () => {
  const [searchTerm, setSearchTerm] = useState("");
  const [activeTab, setActiveTab] = useState("all");

  const grievances = [
    {
      caseId: "CASE-2025-045",
      student: "Maria Elena Santos",
      studentId: "2021-00156",
      type: "Academic Misconduct",
      category: "Academic",
      description: "Suspected plagiarism in final thesis submission",
      status: "Under Investigation",
      priority: "High",
      assignedStaff: "Dr. Elena Rodriguez",
      dateCreated: "2025-01-15",
      lastUpdate: "2025-01-18",
      dueDate: "2025-01-25"
    },
    {
      caseId: "CASE-2025-044",
      student: "John David Cruz", 
      studentId: "2023-00089",
      type: "Harassment",
      category: "Behavioral",
      description: "Verbal harassment of fellow students during class",
      status: "Open",
      priority: "Critical",
      assignedStaff: "Ms. Sarah Chen",
      dateCreated: "2025-01-14",
      lastUpdate: "2025-01-17",
      dueDate: "2025-01-21"
    },
    {
      caseId: "CASE-2025-043",
      student: "Sarah Mae Johnson",
      studentId: "2022-00445", 
      type: "Attendance Issues",
      category: "Academic",
      description: "Excessive absences without proper documentation",
      status: "Resolved",
      priority: "Medium",
      assignedStaff: "Prof. Michael Thompson",
      dateCreated: "2025-01-13",
      lastUpdate: "2025-01-16",
      dueDate: "2025-01-20"
    },
    {
      caseId: "CASE-2025-042",
      student: "Rona Arbe B. Limbago",
      studentId: "2022-00270",
      type: "Property Damage",
      category: "Disciplinary",
      description: "Damage to laboratory equipment during practical session",
      status: "Pending Review",
      priority: "High",
      assignedStaff: "Dr. James Wilson",
      dateCreated: "2025-01-12",
      lastUpdate: "2025-01-15",
      dueDate: "2025-01-19"
    }
  ];

  const getStatusBadge = (status: string) => {
    const variants: Record<string, "default" | "secondary" | "destructive" | "outline"> = {
      "Resolved": "default",
      "Under Investigation": "secondary",
      "Open": "destructive", 
      "Pending Review": "outline",
      "Closed": "default"
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

  const getCategoryColor = (category: string) => {
    const colors: Record<string, string> = {
      "Academic": "bg-blue-100 text-blue-800",
      "Behavioral": "bg-purple-100 text-purple-800", 
      "Disciplinary": "bg-red-100 text-red-800",
      "Administrative": "bg-green-100 text-green-800"
    };
    return colors[category] || "bg-gray-100 text-gray-800";
  };

  const filteredGrievances = grievances.filter(grievance => {
    const matchesSearch = 
      grievance.caseId.toLowerCase().includes(searchTerm.toLowerCase()) ||
      grievance.student.toLowerCase().includes(searchTerm.toLowerCase()) ||
      grievance.type.toLowerCase().includes(searchTerm.toLowerCase()) ||
      grievance.studentId.includes(searchTerm);
    
    if (activeTab === "all") return matchesSearch;
    if (activeTab === "open") return matchesSearch && ["Open", "Under Investigation", "Pending Review"].includes(grievance.status);
    if (activeTab === "resolved") return matchesSearch && grievance.status === "Resolved";
    if (activeTab === "critical") return matchesSearch && grievance.priority === "Critical";
    
    return matchesSearch;
  });

  return (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-3xl font-bold">Grievance Reports</h1>
          <p className="text-muted-foreground">
            Monitor and manage all grievance cases across the university
          </p>
        </div>
        <Button>
          <Plus className="mr-2 h-4 w-4" />
          File New Grievance
        </Button>
      </div>

      {/* Tabs for filtering */}
      <Tabs value={activeTab} onValueChange={setActiveTab} className="w-full">
        <TabsList>
          <TabsTrigger value="all">All Cases</TabsTrigger>
          <TabsTrigger value="open">Open Cases</TabsTrigger>
          <TabsTrigger value="resolved">Resolved</TabsTrigger>
          <TabsTrigger value="critical">Critical Priority</TabsTrigger>
        </TabsList>

        <TabsContent value={activeTab}>
          <Card>
            <CardHeader>
              <CardTitle>
                {activeTab === "all" && "All Grievance Cases"}
                {activeTab === "open" && "Open & Active Cases"}
                {activeTab === "resolved" && "Resolved Cases"}
                {activeTab === "critical" && "Critical Priority Cases"}
              </CardTitle>
              <CardDescription>
                {activeTab === "all" && "Complete list of all grievance reports"}
                {activeTab === "open" && "Cases requiring immediate attention"}
                {activeTab === "resolved" && "Successfully resolved grievance cases"}
                {activeTab === "critical" && "High priority cases requiring urgent action"}
              </CardDescription>
            </CardHeader>
            <CardContent>
              {/* Search and Filters */}
              <div className="flex items-center space-x-4 mb-6">
                <div className="relative flex-1">
                  <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-muted-foreground h-4 w-4" />
                  <Input
                    placeholder="Search by case ID, student name, or type..."
                    value={searchTerm}
                    onChange={(e) => setSearchTerm(e.target.value)}
                    className="pl-10"
                  />
                </div>
                <Select>
                  <SelectTrigger className="w-[180px]">
                    <SelectValue placeholder="Filter by type" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="all">All Types</SelectItem>
                    <SelectItem value="academic">Academic Misconduct</SelectItem>
                    <SelectItem value="harassment">Harassment</SelectItem>
                    <SelectItem value="attendance">Attendance Issues</SelectItem>
                    <SelectItem value="property">Property Damage</SelectItem>
                  </SelectContent>
                </Select>
                <Select>
                  <SelectTrigger className="w-[180px]">
                    <SelectValue placeholder="Assigned staff" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="all">All Staff</SelectItem>
                    <SelectItem value="elena">Dr. Elena Rodriguez</SelectItem>
                    <SelectItem value="sarah">Ms. Sarah Chen</SelectItem>
                    <SelectItem value="michael">Prof. Michael Thompson</SelectItem>
                    <SelectItem value="james">Dr. James Wilson</SelectItem>
                  </SelectContent>
                </Select>
                <Button variant="outline">
                  <Filter className="mr-2 h-4 w-4" />
                  More Filters
                </Button>
              </div>

              <Table>
                <TableHeader>
                  <TableRow>
                    <TableHead>Case ID</TableHead>
                    <TableHead>Student</TableHead>
                    <TableHead>Type</TableHead>
                    <TableHead>Category</TableHead>
                    <TableHead>Status</TableHead>
                    <TableHead>Priority</TableHead>
                    <TableHead>Assigned Staff</TableHead>
                    <TableHead>Due Date</TableHead>
                    <TableHead>Actions</TableHead>
                  </TableRow>
                </TableHeader>
                <TableBody>
                  {filteredGrievances.map((grievance) => (
                    <TableRow key={grievance.caseId} className="hover:bg-muted/50">
                      <TableCell className="font-medium">{grievance.caseId}</TableCell>
                      <TableCell>
                        <div>
                          <div className="font-medium">{grievance.student}</div>
                          <div className="text-sm text-muted-foreground">{grievance.studentId}</div>
                        </div>
                      </TableCell>
                      <TableCell>{grievance.type}</TableCell>
                      <TableCell>
                        <Badge className={getCategoryColor(grievance.category)}>
                          {grievance.category}
                        </Badge>
                      </TableCell>
                      <TableCell>{getStatusBadge(grievance.status)}</TableCell>
                      <TableCell>{getPriorityBadge(grievance.priority)}</TableCell>
                      <TableCell>{grievance.assignedStaff}</TableCell>
                      <TableCell>{grievance.dueDate}</TableCell>
                      <TableCell>
                        <DropdownMenu>
                          <DropdownMenuTrigger asChild>
                            <Button variant="ghost" className="h-8 w-8 p-0">
                              <MoreHorizontal className="h-4 w-4" />
                            </Button>
                          </DropdownMenuTrigger>
                          <DropdownMenuContent align="end">
                            <DropdownMenuItem>
                              <Eye className="mr-2 h-4 w-4" />
                              View Details
                            </DropdownMenuItem>
                            <DropdownMenuItem>
                              <Edit className="mr-2 h-4 w-4" />
                              Update Status
                            </DropdownMenuItem>
                            <DropdownMenuItem>
                              <MessageSquare className="mr-2 h-4 w-4" />
                              Add Comment
                            </DropdownMenuItem>
                          </DropdownMenuContent>
                        </DropdownMenu>
                      </TableCell>
                    </TableRow>
                  ))}
                </TableBody>
              </Table>
            </CardContent>
          </Card>
        </TabsContent>
      </Tabs>

      {/* Summary Cards */}
      <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
        <Card>
          <CardContent className="p-6">
            <div className="text-2xl font-bold">248</div>
            <p className="text-xs text-muted-foreground">Total Cases</p>
          </CardContent>
        </Card>
        <Card>
          <CardContent className="p-6">
            <div className="text-2xl font-bold">42</div>
            <p className="text-xs text-muted-foreground">Active Cases</p>
          </CardContent>
        </Card>
        <Card>
          <CardContent className="p-6">
            <div className="text-2xl font-bold">18</div>
            <p className="text-xs text-muted-foreground">Critical Priority</p>
          </CardContent>
        </Card>
        <Card>
          <CardContent className="p-6">
            <div className="text-2xl font-bold">5.2</div>
            <p className="text-xs text-muted-foreground">Avg Resolution Days</p>
          </CardContent>
        </Card>
      </div>
    </div>
  );
};

export default Grievances;