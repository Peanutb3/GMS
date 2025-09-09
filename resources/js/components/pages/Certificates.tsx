import { useState } from "react";
import { Search, Download, Eye, CheckCircle, Clock, AlertCircle, FileText } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from "@/components/ui/badge";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";

const Certificates = () => {
  const [searchTerm, setSearchTerm] = useState("");
  const [activeTab, setActiveTab] = useState("pending");

  const certificateRequests = [
    {
      requestId: "GMC-2025-001",
      student: "Maria Elena Santos",
      studentId: "2021-00156",
      program: "BS Psychology",
      purpose: "Job Application",
      requestDate: "2025-01-18",
      status: "Approved",
      reviewedBy: "Dr. Elena Rodriguez",
      reviewDate: "2025-01-19",
      grievanceCheck: "Clear",
      notes: "No outstanding grievances. Excellent academic record."
    },
    {
      requestId: "GMC-2025-002", 
      student: "Rona Arbe B. Limbago",
      studentId: "2022-00270",
      program: "BSIT-IS",
      purpose: "Scholarship Application",
      requestDate: "2025-01-17",
      status: "Pending Review",
      reviewedBy: null,
      reviewDate: null,
      grievanceCheck: "Under Review",
      notes: "Pending resolution of CASE-2025-042"
    },
    {
      requestId: "GMC-2025-003",
      student: "Sarah Mae Johnson", 
      studentId: "2022-00445",
      program: "BS Business Administration",
      purpose: "Transfer Application",
      requestDate: "2025-01-16",
      status: "Approved",
      reviewedBy: "Prof. Michael Thompson",
      reviewDate: "2025-01-18",
      grievanceCheck: "Clear",
      notes: "All grievances resolved. Ready for certificate generation."
    },
    {
      requestId: "GMC-2025-004",
      student: "John David Cruz",
      studentId: "2023-00089", 
      program: "BS Engineering",
      purpose: "Internship Application",
      requestDate: "2025-01-15",
      status: "Rejected",
      reviewedBy: "Ms. Sarah Chen",
      reviewDate: "2025-01-17",
      grievanceCheck: "Active Issues",
      notes: "Multiple active grievances. Certificate cannot be issued at this time."
    }
  ];

  const getStatusBadge = (status: string) => {
    const variants: Record<string, "default" | "secondary" | "destructive" | "outline"> = {
      "Approved": "default",
      "Pending Review": "outline",
      "Rejected": "destructive",
      "Generated": "secondary"
    };
    return <Badge variant={variants[status] || "outline"}>{status}</Badge>;
  };

  const getGrievanceCheckBadge = (check: string) => {
    const colors: Record<string, string> = {
      "Clear": "bg-green-100 text-green-800",
      "Under Review": "bg-yellow-100 text-yellow-800",
      "Active Issues": "bg-red-100 text-red-800"
    };
    return (
      <Badge className={colors[check] || "bg-gray-100 text-gray-800"}>
        {check}
      </Badge>
    );
  };

  const filteredRequests = certificateRequests.filter(request => {
    const matchesSearch = 
      request.requestId.toLowerCase().includes(searchTerm.toLowerCase()) ||
      request.student.toLowerCase().includes(searchTerm.toLowerCase()) ||
      request.studentId.includes(searchTerm) ||
      request.program.toLowerCase().includes(searchTerm.toLowerCase());
    
    if (activeTab === "pending") return matchesSearch && request.status === "Pending Review";
    if (activeTab === "approved") return matchesSearch && request.status === "Approved";
    if (activeTab === "rejected") return matchesSearch && request.status === "Rejected";
    if (activeTab === "all") return matchesSearch;
    
    return matchesSearch;
  });

  return (
    <div className="space-y-6">
      {/* Header */}
      <div>
        <h1 className="text-3xl font-bold">Good Moral Certificates</h1>
        <p className="text-muted-foreground">
          Review and manage good moral certificate requests from students
        </p>
      </div>

      {/* Summary Cards */}
      <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
        <Card>
          <CardContent className="p-6">
            <div className="flex items-center gap-4">
              <div className="p-3 bg-yellow-100 rounded-lg">
                <Clock className="h-6 w-6 text-yellow-600" />
              </div>
              <div>
                <div className="text-2xl font-bold">24</div>
                <p className="text-xs text-muted-foreground">Pending Review</p>
              </div>
            </div>
          </CardContent>
        </Card>
        <Card>
          <CardContent className="p-6">
            <div className="flex items-center gap-4">
              <div className="p-3 bg-green-100 rounded-lg">
                <CheckCircle className="h-6 w-6 text-green-600" />
              </div>
              <div>
                <div className="text-2xl font-bold">156</div>
                <p className="text-xs text-muted-foreground">Approved</p>
              </div>
            </div>
          </CardContent>
        </Card>
        <Card>
          <CardContent className="p-6">
            <div className="flex items-center gap-4">
              <div className="p-3 bg-red-100 rounded-lg">
                <AlertCircle className="h-6 w-6 text-red-600" />
              </div>
              <div>
                <div className="text-2xl font-bold">8</div>
                <p className="text-xs text-muted-foreground">Rejected</p>
              </div>
            </div>
          </CardContent>
        </Card>
        <Card>
          <CardContent className="p-6">
            <div className="flex items-center gap-4">
              <div className="p-3 bg-blue-100 rounded-lg">
                <FileText className="h-6 w-6 text-blue-600" />
              </div>
              <div>
                <div className="text-2xl font-bold">188</div>
                <p className="text-xs text-muted-foreground">Total Requests</p>
              </div>
            </div>
          </CardContent>
        </Card>
      </div>

      {/* Tabs for filtering */}
      <Tabs value={activeTab} onValueChange={setActiveTab} className="w-full">
        <TabsList>
          <TabsTrigger value="pending">Pending Review</TabsTrigger>
          <TabsTrigger value="approved">Approved</TabsTrigger>
          <TabsTrigger value="rejected">Rejected</TabsTrigger>
          <TabsTrigger value="all">All Requests</TabsTrigger>
        </TabsList>

        <TabsContent value={activeTab}>
          <Card>
            <CardHeader>
              <CardTitle>
                {activeTab === "pending" && "Pending Certificate Requests"}
                {activeTab === "approved" && "Approved Certificates"}
                {activeTab === "rejected" && "Rejected Requests"}
                {activeTab === "all" && "All Certificate Requests"}
              </CardTitle>
              <CardDescription>
                {activeTab === "pending" && "Certificate requests awaiting admin review"}
                {activeTab === "approved" && "Approved certificates ready for generation"}
                {activeTab === "rejected" && "Rejected certificate requests"}
                {activeTab === "all" && "Complete history of all certificate requests"}
              </CardDescription>
            </CardHeader>
            <CardContent>
              {/* Search and Filters */}
              <div className="flex items-center space-x-4 mb-6">
                <div className="relative flex-1">
                  <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-muted-foreground h-4 w-4" />
                  <Input
                    placeholder="Search by request ID, student name, or ID..."
                    value={searchTerm}
                    onChange={(e) => setSearchTerm(e.target.value)}
                    className="pl-10"
                  />
                </div>
                <Select>
                  <SelectTrigger className="w-[180px]">
                    <SelectValue placeholder="Filter by program" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="all">All Programs</SelectItem>
                    <SelectItem value="psychology">BS Psychology</SelectItem>
                    <SelectItem value="bsit">BSIT-IS</SelectItem>
                    <SelectItem value="business">BS Business Admin</SelectItem>
                    <SelectItem value="engineering">BS Engineering</SelectItem>
                  </SelectContent>
                </Select>
                <Select>
                  <SelectTrigger className="w-[180px]">
                    <SelectValue placeholder="Purpose" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="all">All Purposes</SelectItem>
                    <SelectItem value="job">Job Application</SelectItem>
                    <SelectItem value="scholarship">Scholarship</SelectItem>
                    <SelectItem value="transfer">Transfer</SelectItem>
                    <SelectItem value="internship">Internship</SelectItem>
                  </SelectContent>
                </Select>
              </div>

              <Table>
                <TableHeader>
                  <TableRow>
                    <TableHead>Request ID</TableHead>
                    <TableHead>Student</TableHead>
                    <TableHead>Program</TableHead>
                    <TableHead>Purpose</TableHead>
                    <TableHead>Request Date</TableHead>
                    <TableHead>Status</TableHead>
                    <TableHead>Grievance Check</TableHead>
                    <TableHead>Reviewed By</TableHead>
                    <TableHead>Actions</TableHead>
                  </TableRow>
                </TableHeader>
                <TableBody>
                  {filteredRequests.map((request) => (
                    <TableRow key={request.requestId} className="hover:bg-muted/50">
                      <TableCell className="font-medium">{request.requestId}</TableCell>
                      <TableCell>
                        <div>
                          <div className="font-medium">{request.student}</div>
                          <div className="text-sm text-muted-foreground">{request.studentId}</div>
                        </div>
                      </TableCell>
                      <TableCell>{request.program}</TableCell>
                      <TableCell>{request.purpose}</TableCell>
                      <TableCell>{request.requestDate}</TableCell>
                      <TableCell>{getStatusBadge(request.status)}</TableCell>
                      <TableCell>{getGrievanceCheckBadge(request.grievanceCheck)}</TableCell>
                      <TableCell>{request.reviewedBy || "-"}</TableCell>
                      <TableCell>
                        <div className="flex items-center gap-2">
                          <Button variant="ghost" size="sm">
                            <Eye className="h-4 w-4" />
                          </Button>
                          {request.status === "Approved" && (
                            <Button variant="ghost" size="sm">
                              <Download className="h-4 w-4" />
                            </Button>
                          )}
                          {request.status === "Pending Review" && (
                            <div className="flex gap-1">
                              <Button variant="outline" size="sm" className="text-green-600">
                                Approve
                              </Button>
                              <Button variant="outline" size="sm" className="text-red-600">
                                Reject
                              </Button>
                            </div>
                          )}
                        </div>
                      </TableCell>
                    </TableRow>
                  ))}
                </TableBody>
              </Table>
            </CardContent>
          </Card>
        </TabsContent>
      </Tabs>

      {/* Quick Actions */}
      <Card>
        <CardHeader>
          <CardTitle>Certificate Management Guidelines</CardTitle>
          <CardDescription>
            Important criteria for approving good moral certificate requests
          </CardDescription>
        </CardHeader>
        <CardContent>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <h4 className="font-medium text-green-600 mb-2">✓ Approval Criteria</h4>
              <ul className="text-sm text-muted-foreground space-y-1">
                <li>• No active grievance cases</li>
                <li>• All previous grievances resolved</li>
                <li>• Good academic standing</li>
                <li>• No disciplinary actions in past 6 months</li>
                <li>• Complete required documentation</li>
              </ul>
            </div>
            <div>
              <h4 className="font-medium text-red-600 mb-2">✗ Rejection Criteria</h4>
              <ul className="text-sm text-muted-foreground space-y-1">
                <li>• Active grievance investigations</li>
                <li>• Recent disciplinary actions</li>
                <li>• Unresolved behavioral issues</li>
                <li>• Outstanding academic violations</li>
                <li>• Incomplete student records</li>
              </ul>
            </div>
          </div>
        </CardContent>
      </Card>
    </div>
  );
};

export default Certificates;