import { useState } from "react";
import { Search, MoreHorizontal, Eye, FileText, Award } from "lucide-react";
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

const Students = () => {
  const [searchTerm, setSearchTerm] = useState("");

  const students = [
    {
      id: "STU-2024-001",
      studentId: "2022-00270",
      name: "Rona Arbe B. Limbago",
      email: "rablimbago00270@usep.edu.ph",
      program: "BSIT-IS",
      year: "3rd Year",
      grievanceCount: 1,
      lastGrievance: "2025-01-10",
      moralStatus: "Good Standing",
      canRequestCertificate: true
    },
    {
      id: "STU-2024-002",
      studentId: "2021-00156", 
      name: "Maria Elena Santos",
      email: "mesantos00156@usep.edu.ph",
      program: "BS Psychology",
      year: "4th Year",
      grievanceCount: 0,
      lastGrievance: "Never",
      moralStatus: "Excellent",
      canRequestCertificate: true
    },
    {
      id: "STU-2024-003",
      studentId: "2023-00089",
      name: "John David Cruz",
      email: "jdcruz00089@usep.edu.ph", 
      program: "BS Engineering",
      year: "2nd Year",
      grievanceCount: 3,
      lastGrievance: "2025-01-08",
      moralStatus: "Under Review",
      canRequestCertificate: false
    },
    {
      id: "STU-2024-004",
      studentId: "2022-00445",
      name: "Sarah Mae Johnson",
      email: "smjohnson00445@usep.edu.ph",
      program: "BS Business Administration", 
      year: "3rd Year",
      grievanceCount: 2,
      lastGrievance: "2024-12-15",
      moralStatus: "Good Standing",
      canRequestCertificate: true
    }
  ];

  const getMoralStatusBadge = (status: string) => {
    const variants: Record<string, "default" | "secondary" | "destructive" | "outline"> = {
      "Excellent": "default",
      "Good Standing": "secondary",
      "Under Review": "destructive",
      "Probation": "outline"
    };
    return <Badge variant={variants[status] || "outline"}>{status}</Badge>;
  };

  const filteredStudents = students.filter(student =>
    student.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
    student.studentId.includes(searchTerm) ||
    student.email.toLowerCase().includes(searchTerm.toLowerCase()) ||
    student.program.toLowerCase().includes(searchTerm.toLowerCase())
  );

  return (
    <div className="space-y-6">
      {/* Header */}
      <div>
        <h1 className="text-3xl font-bold">Student Management</h1>
        <p className="text-muted-foreground">
          Monitor student records, grievances, and good moral certificate eligibility
        </p>
      </div>

      {/* Search and Filters */}
      <Card>
        <CardHeader>
          <CardTitle>Student Directory</CardTitle>
          <CardDescription>
            View and manage all registered students in the system
          </CardDescription>
        </CardHeader>
        <CardContent>
          <div className="flex items-center space-x-4 mb-6">
            <div className="relative flex-1">
              <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-muted-foreground h-4 w-4" />
              <Input
                placeholder="Search students by name, ID, email, or program..."
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
                <SelectItem value="bsit">BSIT</SelectItem>
                <SelectItem value="psychology">BS Psychology</SelectItem>
                <SelectItem value="engineering">BS Engineering</SelectItem>
                <SelectItem value="business">BS Business Admin</SelectItem>
              </SelectContent>
            </Select>
            <Select>
              <SelectTrigger className="w-[180px]">
                <SelectValue placeholder="Moral status" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="all">All Status</SelectItem>
                <SelectItem value="excellent">Excellent</SelectItem>
                <SelectItem value="good">Good Standing</SelectItem>
                <SelectItem value="review">Under Review</SelectItem>
                <SelectItem value="probation">Probation</SelectItem>
              </SelectContent>
            </Select>
          </div>

          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Student ID</TableHead>
                <TableHead>Name</TableHead>
                <TableHead>Email</TableHead>
                <TableHead>Program</TableHead>
                <TableHead>Year Level</TableHead>
                <TableHead>Grievances</TableHead>
                <TableHead>Moral Status</TableHead>
                <TableHead>Certificate Eligible</TableHead>
                <TableHead>Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {filteredStudents.map((student) => (
                <TableRow key={student.id} className="hover:bg-muted/50">
                  <TableCell className="font-medium">{student.studentId}</TableCell>
                  <TableCell>{student.name}</TableCell>
                  <TableCell>{student.email}</TableCell>
                  <TableCell>{student.program}</TableCell>
                  <TableCell>{student.year}</TableCell>
                  <TableCell>
                    <div className="flex items-center gap-2">
                      <span className={student.grievanceCount > 0 ? "text-orange-600" : "text-green-600"}>
                        {student.grievanceCount}
                      </span>
                      {student.grievanceCount > 0 && (
                        <Badge variant="outline" className="text-xs">
                          Last: {student.lastGrievance}
                        </Badge>
                      )}
                    </div>
                  </TableCell>
                  <TableCell>{getMoralStatusBadge(student.moralStatus)}</TableCell>
                  <TableCell>
                    {student.canRequestCertificate ? (
                      <Badge className="bg-green-100 text-green-800">Eligible</Badge>
                    ) : (
                      <Badge variant="destructive">Not Eligible</Badge>
                    )}
                  </TableCell>
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
                          View Profile
                        </DropdownMenuItem>
                        <DropdownMenuItem>
                          <FileText className="mr-2 h-4 w-4" />
                          View Grievances
                        </DropdownMenuItem>
                        {student.canRequestCertificate && (
                          <DropdownMenuItem>
                            <Award className="mr-2 h-4 w-4" />
                            Generate Certificate
                          </DropdownMenuItem>
                        )}
                      </DropdownMenuContent>
                    </DropdownMenu>
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </CardContent>
      </Card>

      {/* Summary Statistics */}
      <div className="grid grid-cols-1 md:grid-cols-5 gap-4">
        <Card>
          <CardContent className="p-6">
            <div className="text-2xl font-bold">1,247</div>
            <p className="text-xs text-muted-foreground">Total Students</p>
          </CardContent>
        </Card>
        <Card>
          <CardContent className="p-6">
            <div className="text-2xl font-bold">892</div>
            <p className="text-xs text-muted-foreground">Certificate Eligible</p>
          </CardContent>
        </Card>
        <Card>
          <CardContent className="p-6">
            <div className="text-2xl font-bold">125</div>
            <p className="text-xs text-muted-foreground">With Active Grievances</p>
          </CardContent>
        </Card>
        <Card>
          <CardContent className="p-6">
            <div className="text-2xl font-bold">67</div>
            <p className="text-xs text-muted-foreground">Under Review</p>
          </CardContent>
        </Card>
        <Card>
          <CardContent className="p-6">
            <div className="text-2xl font-bold">163</div>
            <p className="text-xs text-muted-foreground">Certificate Requests</p>
          </CardContent>
        </Card>
      </div>
    </div>
  );
};

export default Students;