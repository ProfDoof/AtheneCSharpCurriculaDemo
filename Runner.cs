using System;
using System.IO;


class Runner
{
    static void Main(string[] args)
    {
        // Console.WriteLine("Start HelloWorldRunner");
        Console.SetIn(new AtheneStreamReader(Console.OpenStandardInput()));
        var program = Activator.CreateInstance(Type.GetType(args[0]));
        
        var runprogram = program.GetType().GetMethod("Main", System.Reflection.BindingFlags.NonPublic | System.Reflection.BindingFlags.Static | System.Reflection.BindingFlags.Public);

        if (runprogram != null)
        {
            runprogram.Invoke(program, new object[] { new string [0] } );
        }
        // Console.WriteLine("End HelloWorldRunner");
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
}