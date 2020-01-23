using System;
using System.IO;


class Runner
{
    static void Main(string[] args)
    {
        // Replaces the standard console stream reader 
        // with my athene stream reader.
        Console.SetIn(new AtheneStreamReader(Console.OpenStandardInput()));

        // In order to use C# Reflection which allows me to invoke methods
        // even if they are private I need to create the students program as
        // an object.
        var program = Activator.CreateInstance(Type.GetType(args[0]));
        
        // This uses C# reflection to get the Main method of the students
        // program.
        var runprogram = program.GetType().GetMethod("Main", System.Reflection.BindingFlags.NonPublic | System.Reflection.BindingFlags.Static | System.Reflection.BindingFlags.Public);

        // Now, as long as the students program has a main method this
        // next statement should be true. However, if it doesn't we should
        // probably throw an exception that says something meaningful to the
        // students.
        if (runprogram != null)
        {
            runprogram.Invoke(program, new object[] { new string [0] } );
        }
    }

    /// <summary>
    /// This class reflects all ReadLine output from stdin to stdout
    /// </summary>
    public class AtheneStreamReader: StreamReader
    {
        public AtheneStreamReader(Stream stream): base(stream) {}

        /// <summary>
        /// This is an overload of the standard ReadLine that reflects all input back to output in the format
        /// <span class=input>{0}</span> where {0} is the input.
        /// </summary>
        /// <returns>The standard input (no real change from default ReadLine</returns>
        public override string ReadLine()
        {
            string line = base.ReadLine();
            System.Console.WriteLine("<span class=input>{0}</span>", line);
            return line;
        }
    }

    // TODO: Define meaningful exceptions that can get thrown by the runner that will make sense to the students.
}